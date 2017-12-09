<?php

namespace Web\Model;

use Web\Model\Settings\BasicModel;
use RedBeanPHP\R;

class Purchases extends BasicModel
{
    const table = 'purchases';

    /**
     * @return bool|object
     */
    public static function get_all()
    {
        $prepare = self::prepare();
        $where = $prepare == '' ? '' : ' WHERE ' . $prepare;

        $having = get('sum') ? " HAVING `sum` LIKE '" . get('sum') . "%'" : '';

        return get_object(R::getAll("
        SELECT 
            `purchases`.*,
            `manufacturers`.`name` AS `manufacturer_name`,
            SUM(`pp`.`amount` * `pp`.`price`) AS `sum`,
            IF (`purchases`.`type` = 1 AND `purchases`.`status` = 2 , 1, 0) AS `close` 
        FROM 
            `purchases`
        LEFT JOIN `manufacturers` ON (`manufacturers`.`id` = `purchases`.`manufacturer`)
        LEFT JOIN `purchases_products` AS `pp` ON (`pp`.`purchases_id` = `purchases`.`id`)
        $where
        GROUP BY 
            `purchases`.`id`
        $having
        "));
    }

    /**
     * @return string
     */
    private static function prepare()
    {
        $str = '';
        $arr = ['date', 'manufacturer', 'status', 'type'];

        foreach ($arr as $key) {
            if (get($key)) {
                $t = "`purchases`.`$key` = '" . get($key) . "'";
                $str .= strlen($str) > 0 ? ' AND ' . $t : $t;
            }
        }

        if (get('view') == 'close') {
            $t = "`purchases`.`status` = 2 AND `purchases`.`type` = 1";
            $str .= strlen($str) > 0 ? ' AND ' . $t : $t;
        } else if (get('view') == false) {
            $t = "`purchases`.`status` IN(0,1) AND `purchases`.`type` = 0";
            $str .= strlen($str) > 0 ? ' AND ' . $t : $t;
        }

        if (get('date_with')) {
            $t = '`purchases`.`date` >= \'' . get('date_with') . '\'';
            $str .= strlen($str) > 0 ? ' AND ' . $t : $t;
        }

        if (get('date_to')) {
            $t = '`purchases`.`date` <= \'' . get('date_to') . '\'';
            $str .= strlen($str) > 0 ? ' AND ' . $t : $t;
        }

        return $str;
    }

    /**'
     * @param $manufacturer_id
     * @return array
     */
    public static function searchProducts($post)
    {
        $not = isset($post->not) && my_count($post->not) > 0 ? ' AND `id` NOT IN(' . implode(',', $post->not) . ') ' : '';

        if ($post->field == 'category') {
            $sql = "`manufacturer` = ? AND `category` = ? $not";
            $binds = [$post->manufacturer, $post->data];
        } elseif ($post->field == 'name') {
            $sql = "`manufacturer` = ? AND `name` LIKE ? $not";
            $binds = [$post->manufacturer, '%' . $post->data . '%'];
        } else {
            $sql = "`manufacturer` = ? AND `services_code` LIKE ? $not";
            $binds = [$post->manufacturer, '%' . $post->data . '%'];
        }

        return (R::findAll('products', $sql, $binds));

    }

    /**
     * @param $post
     * @return array
     */
    public static function getProducts($products)
    {
        $in = implode(',', $products);
        return R::findAll('products', "`id` IN($in)");
    }

    /**
     * @param $id
     * @return array
     */
    public static function getProductsByPurchasesID($id)
    {
        $new = [];
        $products = R::getAll('
            SELECT
                `purchases_products`.*,
                `products`.`name`,
                `products`.`count_on_storage`
                
            FROM 
                `purchases_products`
            LEFT JOIN `products` ON (`products`.`id` = `purchases_products`.`product_id`)
            WHERE 
                `purchases_products`.`purchases_id` = ?
            ORDER BY 
                `purchases_products`.`id`
                ',
            [$id]);

        foreach ($products as $item) {
            $new[$item['product_id']] = $item;
        }

        return ($new);
    }

    /**
     * @param $id
     * @param $products
     */
    public static function update_products($id, $products, $sum, $comment)
    {
        $bean = R::load('purchases', $id);
        $bean->sum = $sum;
        $bean->comment = $comment;
        R::store($bean);

        R::exec("DELETE FROM `purchases_products` WHERE `purchases_id` = $id");

        foreach ($products as $product) {
            $bean = R::xdispense('purchases_products');
            $bean->purchases_id = $id;
            $bean->product_id = $product['id'];
            $bean->amount = $product['amount'];
            $bean->price = $product['price'];

            R::store($bean);
        }

        response(200, 'Дані вдало збережені!');
    }

    /**
     * @param $id
     * @return bool|object
     */
    public static function getToPrint($id)
    {
        $purchase = R::getALl('
        SELECT 
            `purchases`.*,
            `manufacturers`.`name` AS `manufacturer_name`,
            SUM(`purchases_products`.`amount` * `purchases_products`.`price`) AS `sum`
        FROM 
            `purchases`
        LEFT JOIN `manufacturers` ON (`manufacturers`.`id` = `purchases`.`manufacturer`)
        LEFT JOIN `purchases_products` ON (`purchases_products`.`purchases_id` = `purchases`.`id`)
        WHERE 
            `purchases`.`id` = ?
        ORDER BY 
            `purchases`.`id`', [$id]);

        $purchase = $purchase[0];

        $purchase['products'] = R::getAll('
        SELECT
            `purchases_products`.*,
            `products`.`name`,
            `products`.`count_on_storage`
        FROM
            `purchases_products`
        LEFT JOIN `products` ON (`products`.`id` = `purchases_products`.`product_id`)
        WHERE
            `purchases_products`.`purchases_id` = ?
        ', [$id]);

        return (get_object($purchase));
    }

    /**
     * @param $data
     */
    public static function create($post, $response = true)
    {
        $manufacturer = isset($post->manufacturer_id) ? $post->manufacturer_id : '1';
        $products = isset($post->products) ? $post->products : [];
        $sum = isset($post->sum) ? $post->sum : '0';
        $comment = isset($post->comment) ? $post->comment : '';

        $type
            = R::count('purchases', '`manufacturer` = ? AND `type` = 0', [$manufacturer])
            ? 'update'
            : 'create';

        $bean
            = $type == 'update'
            ? R::findOne('purchases', '`manufacturer` = ? AND `type` = 0', [$manufacturer])
            : R::dispense('purchases');

        if($type == 'create') {
            $bean->date = date('Y-m-d');
            $bean->manufacturer = $manufacturer;
            $bean->status = 0;
            $bean->type = 0;
            $bean->sum = $sum;
            $bean->comment = $comment;
            $bean->prepayment = 0;
        }

        $id = R::store($bean);

        foreach ($products as $product) {
            if (!R::count('purchases_products', '`product_id` = ? AND `purchases_id` = ?', [$product['id'], $id])) {

                $bean = R::xdispense('purchases_products');

                $bean->purchases_id = $id;
                $bean->product_id = $product['id'];
                $bean->amount = $product['amount'];
                $bean->price = $product['price'];

                R::store($bean);
            }
        }

        if ($response)
            response(200, 'Всі дані успішно збережено!');
    }

    /**
     * @return array
     */
    public static function getOpenPurchases()
    {
        $all = R::getAll('SELECT DISTINCT `manufacturer` FROM `purchases` WHERE `type` = 0');
        $array = [];

        foreach ($all as $item) {
            $array[] = $item['manufacturer'];
        }

        return $array;
    }

    /**
     * @param $post
     */
    public static function close($post)
    {
        $bean = R::load('purchases', $post->id);
        $bean->status = 2;
        $bean->type = 1;
        R::store($bean);

        $user = user();
        $bean = R::xdispense('control_money_items');

        $bean->name_operation = $post->name_operation;
        $bean->date = date('Y-m-d');
        $bean->sum = self::getSum($post->id);
        $bean->data = json_encode(['id' => $post->id]);
        $bean->comment = $post->comment;
        $bean->user = $user->id;
        $bean->type = 'purchases';

        R::store($bean);

        $products = self::getProductsByPurchasesID($post->id);

        foreach (get_object($products) as $id => $product) {
            $bean = R::load('products', $id);
            $bean->count_on_storage = $bean->count_on_storage + $product->amount;
            R::store($bean);

            $bean = R::xdispense('history_product');
            $bean->product = $id;
            $bean->type = 'purchases';
            $bean->data = json_encode(['amount' => $product->amount, 'price' => $product->price]);
            $bean->date = date('Y-m-d h:i:s');
            $bean->author = $user->id;

            R::store($bean);
        }

        response(200, 'Закупка вдало закрита!');
    }

    /**
     * @param $id
     * @return int
     */
    public static function getSum($id)
    {
        $sum = 0;
        $rows = R::getAll('SELECT `amount`, `price` FROM `purchases_products` WHERE `purchases_id` = ?', [$id]);
        foreach ($rows as $row)
            $sum += $row['amount'] * $row['price'];

        return $sum;
    }

    /**
     * @param $sum
     * @param $purchases
     */
    public static function prepayment_control_money($sum, $purchases)
    {
        $bean = R::load('purchases', $purchases);
        $manufacturer_id = $bean->manufacturer;

        $bean = R::load('manufacturers', $manufacturer_id);
        $manufacturer_name = $bean->name;

        $bean = R::xdispense('control_money_items');

        $bean->name_operation = "Предоплата по закупці товару виробника \"$manufacturer_name\"";
        $bean->date = date('Y-m-d');
        $bean->sum = $sum;
        $bean->data = json_encode(['id' => $purchases]);
        $bean->user = user()->id;
        $bean->type = 'purchases_prepayment';
        $bean->comment = '';

        R::store($bean);
    }
}