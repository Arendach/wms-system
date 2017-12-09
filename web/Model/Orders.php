<?php

namespace Web\Model;

use RedBeanPHP\R;
use Web\App\Paginator;
use Web\App\Config;
use Web\Model\Settings\BasicModel AS Model;

class Orders extends Model
{
    const table = 'orders';

    /**
     * @param $id
     * @return array
     */
    public static function getOrder($id)
    {
        return R::getRow('
            SELECT 
                `orders`.*,
                `couriers`.`name` AS `courier`,
                `logistics`.`name` AS `delivery`,
                `pays`.`name` AS `pay_method` 
            FROM 
                `orders`
            LEFT JOIN `couriers` ON (`couriers`.`id` = `orders`.`courier`) 
            LEFT JOIN `logistics` ON(`logistics`.`id` = `orders`.`delivery`)
            LEFT JOIN `pays` ON(`pays`.`id` = `orders`.`pay_method`)
            WHERE 
                `orders`.`id` = ?
            GROUP BY 
                `orders`.`id`', [$id]);
    }

    /**
     * @param $type
     * @return array
     */
    public static function orderDataByType($type)
    {
        // кількість пунктів на сторінку
        $items = Config::items();

        // початок вибірки
        $start_query = (get('page') - 1) * $items;

        $sql = '`orders`.`type` = \'' . $type . '\'';

        if (get('id'))
            $sql .= ' AND `orders`.`id` LIKE \'' . get('id') . '%\'';

        if (get('fio'))
            $sql .= ' AND `orders`.`fio` LIKE \'%' . get('fio') . '%\'';

        if (get('phone'))
            $sql .= ' AND `orders`.`phone` LIKE \'' . get('phone') . '%\'';

        if (get('date'))
            $sql .= ' AND DATE(`orders`.`date`) = \'' . get('date') . '\'';

        if (get('courier'))
            $sql .= ' AND `orders`.`courier` = \'' . get('courier') . '\'';

        if (get('time_with') !== false)
            $sql .= ' AND `orders`.`time_with` >= \'' . time_to_string(get('time_with')) . '\' ';

        if (get('time_to'))
            $sql .= ' AND `orders`.`time_to` <= \'' . time_to_string(get('time_to')) . '\' ';

        if (get('region'))
            $sql .= ' AND `orders`.`street` LIKE \'%(' . preg_replace("/'/", "\'", get('region')) . ')\'';

        $having = '';
        if (get('full_sum'))
            $having = 'HAVING `full_sum` LIKE \'' . get('full_sum') . '%\'';

        if (get('status') !== false)
            $sql .= 'AND `orders`.`status` = ' . get('status');

        $paginate = Paginator::simple('orders', $sql);

        $data = R::getAll("
            SELECT 
                `orders`.*, 
                `couriers`.`name` AS `courier`,
                `colors`.`description` AS `description`,
                `colors`.`color` AS `color`,
                `logistics`.`name` AS `delivery`,
                SUM(`pto`.`amount` *  `pto`.`price`) as `full_sum`
            FROM 
                `orders`
            LEFT JOIN `couriers` ON (`orders`.`courier` = `couriers`.`id`) 
            LEFT JOIN `colors` ON(`colors`.`id` = `orders`.`hint`) 
            LEFT JOIN `logistics` ON(`logistics`.`id` = `orders`.`delivery`) 
            LEFT JOIN `product_to_order` AS `pto` ON(`pto`.`order_id` = `orders`.`id`) 
            WHERE 
                $sql 
            GROUP BY 
                `orders`.`id` 
            $having
            ORDER BY `orders`.`id` DESC
            LIMIT $start_query, $items");

        return ['data' => $data, 'paginate' => $paginate];
    }

    /**
     * @param $id
     * @return bool|object
     */
    public static function getOrderById($id)
    {
        $r = R::getRow('
            SELECT 
                `orders`.*, `logistics`.`name` AS `logistic_name`,
                `couriers`.`name` AS `courier_name`,
                `pays`.`name` AS `pay_name`,
                `colors`.`description` AS `hint_name`,
                SUM(`pto`.`amount` *  `pto`.`price`) AS `full_sum`

            FROM 
                `orders` 
            LEFT JOIN `logistics` ON (`logistics`.`id` = `orders`.`delivery`) 
            LEFT JOIN `couriers` ON(`couriers`.`id` = `orders`.`courier`)
            LEFT JOIN `pays` ON (`pays`.`id` = `orders`.`pay_method`)
            LEFT JOIN `colors` ON (`colors`.`id` = `orders`.`hint`)
            LEFT JOIN `product_to_order` AS `pto` ON(`pto`.`order_id` = ' . $id . ') 
            WHERE 
                `orders`.`id` = ? ', [$id]);

        return (get_object($r));
    }

    /**
     * @param $id
     * @return bool|object
     */
    public static function get_changes_by_id($id)
    {
        $result = R::getAll('
            SELECT
                `changes`.*,
                `users`.`login` AS `login`
            FROM
                `changes`
            LEFT JOIN `users` ON(`users`.`id` = `changes`.`author`)
            WHERE
                `changes`.`id_order` = ?
            ORDER BY `changes`.`id` DESC
        ', [$id]);

        return (get_object($result));
    }

    /**
     * @param $id
     * @return array
     */
    public static function getProductsByOrderId($id)
    {
        return R::getAll('
            SELECT
                `products`.*,
                `product_to_order`.`attributes` AS `attr`,
                `product_to_order`.`id` AS `pto`,
                `product_to_order`.`amount` AS `amount`,
                `product_to_order`.`price` AS `price`,
                `product_to_order`.`place` AS `place`
            FROM
                `product_to_order`
            LEFT JOIN `products` ON(`products`.`id` = `product_to_order`.`product_id`)
            WHERE 
                `product_to_order`.`order_id` = ?
            GROUP BY 
                `product_to_order`.`id`
        ',
            [$id]);
    }


    /**
     * @param $data
     */
    public static function drop_product($data)
    {
        $user = user();
        $date = date('Y-m-d h:i:s');

        $pto = R::load('product_to_order', $data->pto);
        $amount_in_order = $pto->amount;
        if (empty($pto)) response(400, 'Такого товару в замовленні не існує!');

        $bean = R::load('products', $pto->product_id);
        if ($bean->type_product == 'combine') {
            $linked = R::getAll('SELECT * FROM `combine_product` WHERE `product_id` = ?', [$pto->product_id]);
            foreach ($linked as $item) {
                $bean2 = R::load('products', $item['linked_id']);
                $bean2->count_on_storage = ($amount_in_order * $item['combine_minus']) + $bean2->count_on_storage;
                R::store($bean2);
            }
        }

        $bean->count_on_storage = $bean->count_on_storage + $amount_in_order;

        // Видаляємо товар з замовлення
        R::exec('DELETE FROM `product_to_order` WHERE `id` = ?', [$pto->id]);

        $c = R::dispense('changes');

        $c->type = 'delete_product';
        $c->date = $date;
        $c->id_order = $pto->order_id;
        $c->author = $user->id;
        $c->data = json_encode(['id' => $bean->id, 'name' => $bean->name]);

        R::store($c);

        $h = R::xdispense('history_product');

        $h->type = 'deleted_product_with_order';
        $h->product = $bean->id;
        $h->author = $user->id;
        $h->data = json_encode(['order' => $pto->order_id]);
        $h->date = date('Y-m-d h:i:s');

        R::store($h);

        response(200, 'Дані успішно збережено!');
    }

    /**
     * @param $data
     * @return array
     */
    public static function get_product_by_id($data)
    {
        $in = implode(",", $data->products);
        $not = isset($data->has_id) ? ' AND `products`.`id` NOT IN (' . implode(",", $data->has_id) . ')' : '';
        return R::getAll("
            SELECT 
                `products`.*
            FROM
                `products`
            WHERE 
                `products`.`id` IN ($in) $not 
            AND `products`.`archive` = 0 
            GROUP BY 
                `products`.`id`
            LIMIT 5");
    }

    /**
     * @param $id
     * @return array
     */
    public static function findById($id)
    {
        return R::findAll('product_to_order', '`order_id` = ?', [$id]);
    }

    /**
     * @param $id
     * @return \RedBeanPHP\OODBBean
     */
    public static function get_return_shipping($id)
    {
        return (R::findOne('return_shipping', '`order_id` = ?', [$id]));
    }

    /**
     * @param $type
     * @param $id
     */
    public static function change_type($type, $id)
    {
        $type_name = $type == 'self' ? 'Самовивіз' : 'Доставка';
        $bean = R::load('orders', $id);
        $bean->type = $type;
        R::store($bean);

        $bean = R::dispense('changes');
        $bean->data = 'Змінено тип на "' . $type_name . '"';
        $bean->id_order = $id;
        $bean->type = 'update_type';
        $bean->date = date('Y-m-d');
        $bean->author = user()->id;
        R::store($bean);

        redirect(route('order_update', ['id' => $id]));
    }
}



