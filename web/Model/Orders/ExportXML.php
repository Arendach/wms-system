<?php

namespace Web\Model\Orders;

use Web\Model\Settings\BasicModel;
use RedBeanPHP\R;

class ExportXML extends BasicModel
{
    const source = 'Na Podarok';
    const description = 'Сувеніри';
    const pay_post = 'Готівкова';
    /*const pay_post = 'Безготівкова';*/

    /**
     * @param $order_id
     * @return \RedBeanPHP\OODBBean
     */
    public static function getReturnShipping($order_id, $data)
    {
        $bean = R::findOne('return_shipping', '`order_id` = ?', [$order_id]);

        foreach ($bean as $k => $v) {
            $data['return_shipping'][$k] = $v;
        }

        if ($data['return_shipping']['type'] == 'none') {
            unset($data['return_shipping']['type_remittance']);
            unset($data['return_shipping']['card']);
            unset($data['return_shipping']['sum']);
            unset($data['return_shipping']['payer']);
        } elseif ($data['return_shipping'] == 'documents' && $data['return_shipping'] == 'other') {
            unset($data['return_shipping']['type_remittance']);
            unset($data['return_shipping']['card']);
        } else {
            if ($data['return_shipping']['type_remittance'] == 'imposed') {
                unset($data['return_shipping']['card']);
            }
        }

        unset($data['return_shipping']['order_id']);
        unset($data['return_shipping']['id']);

        return $data;
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     */
    public static function getData($order_id, $data)
    {

        $arr = [
            'name' => 'fio',
            'phone' => 'phone',
            'email' => 'email',
            'date' => 'date',
            'address' => 'address',
            'payercomment' => 'comment',
            'sklad' => 'warehouse',
            'city' => 'city'
        ];

        $bean = R::load('orders', $order_id);

        foreach ($arr as $k => $v) {
            $data[$k] = $bean->$v;
        }

        return $data;
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     */
    public static function getPay($order_id, $data)
    {
        $bean = R::load('orders', $order_id);

        $data['paymentstatus'] = $bean->payment_status ? 'Оплачено' : 'Не оплачено';
        $data['paymentType'] = $bean->form_delivery;
        $data['imposed'] = $bean->form_delivery == 'imposed' ? $bean->imposed : '';
        $data['pay_delivery'] = $bean->pay_delivery;

        $bean->status = 1;
        R::store($bean);

        return $data;
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     */
    public static function getPrice($order_id, $data)
    {
        $order = R::load('orders', $order_id);
        $bean = R::getAll('SELECT `price`, `amount` FROM `product_to_order` WHERE `order_id` = ?', [$order_id]);

        $sum = 0;
        foreach ($bean as $item) {
            $sum += $item['amount'] * $item['price'];
        }

        $data['priceUAH'] = $sum - $order->prepayment;

        return $data;
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     */
    public static function getDelivery($order_id, $data)
    {
        $bean = R::load('orders', $order_id);

        $delivery = R::load('logistics', $bean->delivery);

        $data['deliveryType'] = $delivery->name;

        return $data;
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     */
    public static function getSource($order_id, $data)
    {
        $data['source'] = self::source;
        $data['description'] = self::description;
        $data['pay_post'] = self::pay_post;

        return $data;
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     */
    public static function getProducts($order_id, $data)
    {
        $products = R::findAll('product_to_order', '`order_id` = ?', [$order_id]);

        foreach ($products as $item) {

            $product = R::load('products', $item->product_id);

            // Костиль! Щоб не було нулів, краще одиниця
            if ($item->amount == 0) $item->amount = 1;

            $data['items']['item'][] = [
                '@id' => $item->product_id,                     // ІД товару(атрибут)
                'quantity' => $item->amount,                    // Кількість одиниць товару
                'name' => $product->name,                       // Кількість одиниць товару
                'price' => $item->price,                        // ціна
                'currency' => 'UAH',                            // ціна
                'external_id' => $product->articul,             // Артикул

            ];
        }

        return $data;
    }

    /**
     * @param $order_id
     * @param $data
     * @return mixed
     */
    public static function getPlaces($order_id, $data)
    {
        $products = R::findAll('product_to_order', '`order_id` = ?', [$order_id]);

        $places = [];
        $temp = [];
        foreach ($products as $item) {
            $temp[$item->place][] = $item;
        }

        foreach ($temp as $place => $products) {
            $places[$place]['volume'] = 0;
            $places[$place]['weight'] = 0;
            foreach ($products as $product){
                $bean = R::load('products', $product->product_id);
                $places[$place]['weight'] += $bean->weight * $product->amount;
                $places[$place]['volume'] += $bean->volume * $product->amount;
            }
        }

        foreach ($places as $place => $item) {
            $data['places']['place'][] = [
                '@id' => $place,               // ІД товару(атрибут)
                 'weight' => $item['weight'],  // Альтернативна вага
                 'volume' => $item['volume'],  // Альтернативний обєм
            ];
        }

        $data['count_place'] = my_count($places);

        return $data;
    }

}