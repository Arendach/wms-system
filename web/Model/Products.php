<?php

namespace Web\Model;

use Couchbase\Exception;
use RedBeanPHP\R;
use Web\App\Paginator;
use Web\Model\Settings\BasicModel;
use Web\Tools\ImageUpload;

class Products extends BasicModel
{
    const table = 'products';

    const combine = 'combine_product';

    /**
     * @param $where
     * @return array
     */
    public static function search($where)
    {
        return R::findAll(self::table, $where . ' AND `archive` = 0');
    }

    /**
     * Оновлення типу замовлення (Підчіплюємо комбіновані товари)
     */
    public static function update_type($data, $id)
    {
        $data = get_object($data);
        $array = isset($data->array) ? $data->array : [];
        $type = isset($data->type) ? $data->type : 'once';
        $costs = isset($data->costs) ? $data->costs : '';

        // Для таблиць з префіксом
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        R::exec('DELETE FROM `combine_product` WHERE `product_id` = ?', [$id]);

        if ($type == 'combine') {
            foreach ($array as $key => $item) {
                $combine = R::xdispense('combine_product');
                $combine->product_id = $id;
                $combine->linked_id = $item->id;
                $combine->combine_price = $item->cost;
                $combine->combine_minus = $item->minus;
                R::store($combine);
            }
        }

        $product = R::findOne(self::table, "`id` = $id");
        $product->type_product = $type;
        $product->costs = $costs;
        R::store($product);

        response('200', 'Вдало виконано!');
    }

    /**
     * Пошук для комбінування
     */
    public static function searchCombine($like)
    {
        return R::findAll('products', "`name` LIKE '$like%' LIMIT 8");
    }

    /**
     * Генерація SQL запиту
     */
    private static function part($archive = false)
    {
        $part = $archive === true ? '`products`.`archive` = 1' : '`products`.`archive` = 0';
        $and = "\n AND \n";
        $like = ['products-name', 'categories-name', 'manufacturers-name', 'products-identefire_storage', 'products-articul', 'products-costs'];
        $sum = ['products-count_on_storage', 'products-type_product', 'products-storage'];

        foreach (get() as $k => $v) {
            $exp = explode('-', $k);
            if (in_array($k, $like)) {
                if (strlen(get($k)) > 2)
                    $part .= $and . "`" . $exp[0] . "`.`" . $exp[1] . "` LIKE '%" . get($k) . "%'";
            } elseif (in_array($k, $sum)) {
                $part .= $and . "`" . $exp[0] . "`.`" . $exp[1] . "` = '" . get($k) . "'";
            }
        }
        return $part;
    }

    /**
     * @return string
     */
    private static function orderBy()
    {
        if (get('order_field') == 'count_on_storage' || get('order_field') == 'costs') {
            $by = get('order_by') == 'desc' ? 'DESC' : 'ASC';
            return (' ORDER BY `products`.`' . get('order_field') . '` ' . $by . ' ');
        }

        return ' ';
    }

    /**
     * Шукаємо замовлення в базі даних
     */
    public static function getAll($archive = false)
    {
        $part = self::part($archive);
        $sql = self::SQL() . $part . self::orderBy() . Paginator::limit();
        $data = R::getAll($sql);

        $paginate = Paginator::simple('products', $part);

        return (get_object(['data' => $data, 'paginate' => $paginate]));
    }

    /**
     * Шаблон SQL запиту
     */
    public static function SQL()
    {
        return '
            SELECT
                `products`.*,
                `storage`.`name` AS `storage_name`,
                `manufacturers`.`id` AS `manufacturer_id` ,
                `manufacturers`.`name` AS `manufacturer_name`,
                `categories`.`id` AS `category_id`,
                `categories`.`name` AS `category_name`
            FROM
                `products`
            LEFT JOIN `manufacturers` ON (`manufacturers`.`id` = `products`.`manufacturer`)
            LEFT JOIN `categories` ON (`categories`.`id` = `products`.`category`) 
            LEFT JOIN `storage` ON (`products`.`storage` = `storage`.`id`) 
            WHERE
            ';
    }

    /**
     * @param string $column
     * @param string $like
     */
    public static function likeCondition($column = '`manufacturers`.`name`', $like = '')
    {
        $sql = Products::withRelationsSQL();
        dd(get_object(R::getAll($sql . " WHERE {$column} LIKE '%{$like}%'")));
    }

    /**
     * Вертаєм інформацію про товар
     */
    public static function getProduct($id)
    {
        $sql = self::SQL() . " `products`.`id` = $id LIMIT 1";
        return get_object(R::getRow($sql));
    }

    /**
     * Товар в архів
     */
    public static function to_archive($id)
    {
        R::exec("UPDATE `products` SET `archive` = 1 WHERE `id` = '" . $id . "'");
        return true;
    }

    /**
     * Товар з архіву
     */

    public static function un_archive($id)
    {
        R::exec("UPDATE `products` SET `archive` = 0 WHERE `id` = '" . $id . "'");
        return true;
    }

    /**
     * @param $id
     * @return \RedBeanPHP\OODBBean
     */
    public static function one($id)
    {
        return R::load(self::table, $id);
    }

    /**
     * Вернути комбіновані товари
     */

    public static function getCombine($id)
    {
        $sql = 'SELECT 
            `combine_product`.*,
            `products`.`name`
            FROM `combine_product`
            LEFT JOIN `products` ON (`products`.`id` = `combine_product`.`linked_id`)
            WHERE 
                `combine_product`.`product_id` = ?
            GROUP BY 
                `combine_product`.`id`
        ';

        $products = R::getAll($sql, [$id]);
        return $products;
    }

    /**
     * Вернути історію товару
     */

    public static function getHistory($id)
    {
        return R::findAll('history_product', '`product` = \'' . $id . '\'');
    }

    /**
     * Зберегти зміни в історію
     */

    public static function saveHistory($obj)
    {
        // Відредаговані дані (з форми)
        $e = $obj;

        // Оригінальні дані в базі даних
        $o = R::load('products', $obj->id);

        // Для таблиць з префіксом
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        // Таблички з якими працюємо
        $h = R::xdispense('history_product'); // історія

        // Масив даних для вставки в базу даних (Історія)
        $a = [];
        $a['name'] = $e->name != $o->name ? $e->name : '0';
        $a['articul'] = $e->articul != $o->articul ? $e->articul : '0';
        $a['description'] = isset($e->description) && $e->description != $o->description ? $e->description : '0';
        $a['model'] = $e->model != $o->model ? $e->model : '0';
        $a['identifire_storage'] = isset($e->identifire_storage) && $e->identifire_storage != $o->identifire_storage ? $e->identifire_storage : '0';
        $a['services_code'] = $e->services_code != $o->services_code ? $e->services_code : '0';
        $a['count_on_storage'] = $e->count_on_storage != $o->count_on_storage ? $e->count_on_storage : '0';
        $a['procurement_cost'] = isset($e->procurement_cost) && $e->procurement_cost != $o->procurement_cost ? $e->procurement_cost : '0';
        $a['type_product'] = $e->type_product != $o->type_product ? $e->type_product : '0';
        $a['costs'] = $e->costs != $o->costs ? $e->costs : '0';
        $a['attr_id'] = isset($e->attr_id) && $e->attr_id != $o->attr_id ? $e->attr_id : '0';
        $a['storage'] = $e->storage != $o->storage ? $e->storage : '0';
        $a['main_image'] = isset($e->main_image) && $e->main_image != $o->main_image ? $e->main_image : '0';
        $a['images'] = isset($images) && $images != $o->images ? $images : '0';
        $a['price'] = $e->price != $o->price ? $e->price : '0';
        $a['sort'] = $e->sort != $o->sort ? $e->sort : '0';
        $a['archive'] = isset($e->archive) && $e->archive != $o->archive ? $e->archive : '0';

        // Видаляємо не змінені поля з масиву
        foreach ($a as $k => $v) {
            if ($v == '0') {
                unset($a[$k]);
            }
        }

        // Якщо в масиві більше одного зміненого елемента , зберігаємо в базу даних
        if (count($a) > 0) {
            // Форматуэмо масив в JSON формат
            $data = json_encode($a);

            // Дані для історії
            $h->product = $e->id;
            $h->type = 'edit_product';
            $h->data = $data;
            $h->date = time();

            // Збереження історії
            R::store($h);
        }
    }

    /**
     * Зберігаємо товар
     */
    public static function save($data)
    {
        $user = user();
        $date = date('Y-m-d h:i:s');

        $product = R::dispense('products');
        $history = R::xdispense('history_product');
        $history_array = new \stdClass();

        foreach ($data->data as $k => $v) {
            $product->$k = $v;
            $history_array->$k = $v;
        }

        $product->volume = json_encode($data->data['volume']);
        $product->attributes = json_encode($data->attribute);
        $product->count_on_storage = 0;
        $history_array->attributes = json_encode($data->attribute);

        $product->date = $date;
        $product->author = $user->id;

        $history->date = $date;
        $history->author = $user->id;

        $id = R::store($product);

        $p_bean = R::load('products', $id);
        self::create_purchase($p_bean);

        $history->product = $id;

        if ($data->data['type_product'] == 'combine') {

            $history_combine = [];
            $i = 0;
            foreach ($data->combine as $key => $item) {
                $combine = R::xdispense('combine_product');
                $combine->product_id = $id;
                $combine->linked_id = $item['id'];
                $combine->combine_price = $item['cost'];
                $combine->combine_minus = $item['minus'];
                R::store($combine);
                $history_combine[$i]['product_id'] = $id;
                $history_combine[$i]['linked_id'] = $item['id'];
                $history_combine[$i]['combine_price'] = $item['cost'];
                $history_combine[$i]['combine_minus'] = $item['minus'];
                $i++;
            }
            $history_array->combine = $history_combine;
        }

        $history->type = 'original';
        $history->data = json_encode($history_array);

        R::store($history);

        ImageUpload::save_images($id);
        response(200, 'Вдало!');

    }

    /**
     * @param $data
     * @param $id
     */
    public static function update_attribute($data, $id)
    {
        try {
            R::exec('UPDATE `products` SET `attributes` = ? WHERE `id` = ?', [$data, $id]);
            response(200, 'Аттрибути вдало оновлено!');
        } catch (Exception $err) {
            \Web\App\Log::error($err, 'update_error');
        }
    }

    /**
     * @param $id
     * @param $amount
     */
    public static function copy($id, $amount)
    {
        $fields = ['name', 'articul', 'description', 'model', 'identefire_storage', 'services_code', 'count_on_storage',
            'procurement_costs', 'type_product', 'costs', 'storage', 'sort', 'archive', 'attributes', 'manufacturer',
            'category', 'weight', 'volume'
        ];

        $product = R::load('products', $id);

        for ($i = 0; $i < $amount; $i++) {
            // Новий товар
            $copy_product = R::xdispense('products');

            // Присвоювання полів новому товару
            foreach ($fields as $key) {
                $copy_product->$key = $product->$key;
            }

            // Імя нового товару з поміткою ** Копія **
            $copy_product->name = '** Копія ** ' . $product->name;
            $copy_product->services_code = self::get_service_code($product->category);

            // ІД створеного товару
            $id = R::store($copy_product);

            if ($product->type_product == 'combine') {
                // Всы звязані товари
                $combine_all = R::findAll('combine_product', '`product_id` = ?', [$product->id]);

                // Перебираєм привязані товари і створюєм нові записи в БД
                foreach ($combine_all as $item) {
                    $combine = R::xdispense('combine_product');
                    $combine->product_id = $id;
                    $combine->linked_id = $item->linked_id;
                    $combine->combine_price = $item->combine_price;
                    $combine->combine_minus = $item->combine_minus;
                    R::store($combine);
                }
            }
        }
        response(200, "Товар вдало скопійовано $amount раз(ів)");
    }

    /**
     * @param $category_id
     * @return bool|int
     */
    public static function get_service_code($category_id)
    {
        $bean = R::load('categories', $category_id);

        if ($bean->id == 0)
            return (bool)false;

        $service_code = $bean->service_code * 100;

        $bean = R::findOne('products', 'WHERE `category` = ? ORDER BY `id` DESC', [$category_id]);

        if (!empty($bean))
            $service_code = $bean->services_code + 1;

        return (int)$service_code;
    }

    /**
     * @param $data
     * @param $id
     * @param bool $table
     */
    public static function update($data, $id, $table = false)
    {
        $bean = R::load('products', $id);
        foreach ($data as $k => $v) $bean->$k = $v;
        R::store($bean);
        response(200, 'Інформацію вдало оновлено!');
    }

    /**
     * @param $p_bean
     */
    private static function create_purchase($p_bean)
    {
        Purchases::create((object)[
            'manufacturer_id' => $p_bean->manufacturer,
            'products' => [
                [
                    'id' => $p_bean->id,
                    'amount' => '1',
                    'price' => $p_bean->costs
                ]
            ],
            'sum' => $p_bean->costs,
            'comment' => 'Створено автоматично!!!'
        ], false);
    }
}
