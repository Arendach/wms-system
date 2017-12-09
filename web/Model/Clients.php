<?php

namespace Web\Model;

use Web\App\Paginator;
use RedBeanPHP\R;
use Web\Model\Settings\BasicModel as Model;

class Clients extends Model
{
    const table = 'clients';

    /**
     * @return array
     */
    public static function getClients()
    {
        $clients = R::getAll('SELECT `clients`.*, `clients_group`.`name` AS `group_name` FROM `clients` LEFT JOIN `clients_group` ON(`clients_group`.`id` = `clients`.`group`) GROUP BY `clients`.`id`');
        $paginate = Paginator::simple('clients', 'id > 0');
        return ['clients' => $clients, 'paginate' => $paginate];
    }

    /**
     * @param $id
     * @return object
     */
    public static function getClient($id)
    {
        return (object)R::getRow('
            SELECT 
                `clients`.*,
                 `clients_group`.`name` AS `group_name` 
            FROM 
                `clients` 
            LEFT JOIN `clients_group` ON(`clients_group`.`id` = `clients`.`group`) 
            WHERE 
                `clients`.`id` = ?', [$id]);
    }

    /**
     * @param $id
     * @return array
     */
    public static function getOrders($id)
    {
        return R::getAll('
            SELECT
                `client_orders`.`id` AS `cl_id`,
                `client_orders`.`order_id` AS `cl_id_order`,
                `client_orders`.`client_id` AS `cl_id_client`,
                `orders`.*,
                SUM(`pto`.`amount` *  `pto`.`price`) + `orders`.`delivery_cost` - `orders`.`discount` AS `full_sum`,            
                `regions`.`name` AS `region_name`
            FROM
                `client_orders`
            LEFT JOIN `orders` ON(`orders`.`id` = `client_orders`.`order_id`)
            LEFT JOIN `regions` ON(`regions`.`id` = `orders`.`region`)
            LEFT JOIN `product_to_order` AS `pto` ON(`pto`.`order_id` = `client_orders`.`order_id`) 
            WHERE 
                `client_orders`.`client_id` = ? 
                GROUP BY `client_orders`.`id`
            ORDER BY 
                `client_orders`.`id` DESC', [$id]);
    }

    /**
     * @param $post
     */
    public static function order_remove($post)
    {
        $sql = 'DELETE FROM `client_orders` WHERE `order_id` = ? AND `client_id` = ?';
        R::exec($sql, [$post->order, $post->client]);
        response(200, 'Замовлення вдало видалено!');
    }

    /**
     * @param $data
     * @return array
     */
    public static function search_order($data)
    {
        $sql = '';
        $and = ' AND ';

        if (isset($data->id)) {
            $part = '`id` LIKE \'' . $data->id . '%\'';
            $sql .= $sql == '' ? $part : $and . $part;
        }

        if (isset($data->name)) {
            $part = '`fio` LIKE \'' . $data->name . '%\'';
            $sql .= $sql == '' ? $part : $and . $part;
        }
        if (isset($data->phone)) {
            $part = '`phone` LIKE \'' . $data->phone . '%\'';
            $sql .= $sql == '' ? $part : $and . $part;
        }
        if (isset($data->date)) {
            $part = 'DATE(`date`) = \'' . $data->date . '\'';
            $sql .= $sql == '' ? $part : $and . $part;
        }

        $sql .= ' LIMIT 10';

        return R::findAll('orders', $sql);
    }

    /**
     * @param $id
     * @return array
     */
    public static function getOrdersByClient($id)
    {
        return R::getAll('SELECT `order_id` FROM `client_orders` WHERE `client_id` = ?', [$id]);
    }

    /**
     * @param $data
     */
    public static function save_orders($data)
    {
        // Для таблиць з префіксом
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        foreach ($data->orders as $k => $v) {
            $c = R::xdispense('client_orders');
            $c->client_id = $data->client;
            $c->order_id = $v;
            R::store($c);
        }

        response('200', 'Збережено!');
    }
}