<?php

namespace Web\Model\Orders;

use Web\Model\Settings\BasicModel;
use RedBeanPHP\R;

class PrintModel extends BasicModel
{
    const table = 'orders';

    /**
     * @param $id
     * @return mixed
     */
    public static function getProducts($id)
    {
        $pto = R::findAll('product_to_order', '`order_id` = ?', [$id]);
        $new = [];
        $places = [];
        $sum = 0;
        $i = 0;
        foreach ($pto as $item) {
            $bean = R::load('products', $item->product_id);
            $new[$i]['amount'] = $item->amount;
            $new[$i]['place'] = $item->place;
            $new[$i]['price'] = $item->price;
            $new[$i]['name'] = $bean->name;
            $new[$i]['identefire_storage'] = $bean->identefire_storage;
            $new[$i]['sum'] = $item->amount * $item->price;
            $sum += $item->amount * $item->price;
            $places[$item->place]['weight']
                = isset($places[$item->place]['weight'])
                ? $places[$item->place]['weight'] + $item->amount * $bean->weight
                : $item->amount * $bean->weight;
            $places[$item->place]['volume']
                = isset($places[$item->place]['volume'])
                ? $places[$item->place]['volume'] + $item->amount * self::volume_calculator($bean->volume)
                : $item->amount * self::volume_calculator($bean->volume);
        }
        return get_object(['products' => $new, 'places' => $places, 'sum' => $sum]);
    }

    /**
     * @param $str
     * @return float|int
     */
    private static function volume_calculator($str)
    {
        $array = json_decode($str);
        if (is_string($array) || is_float($array))
            return $array;
        if (!isset($array[0])) $array[0] = 0;
        if (!isset($array[1])) $array[1] = 0;
        if (!isset($array[2])) $array[2] = 0;

        return ($array[0] * $array[1] * $array[2]) / 1000000;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getDeliveryName($id)
    {
        $bean = R::load('logistics', $id);
        return $bean->name;
    }

    /**
     * @param $id
     * @return object
     */
    public static function getPay($id)
    {
        return (object)R::findOne('return_shipping', '`order_id` = ?', [$id]);
    }
}