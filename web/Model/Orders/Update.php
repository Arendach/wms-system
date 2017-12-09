<?php

namespace Web\Model\Orders;

use RedBeanPHP\R;
use Web\Model\OrderSettings;
use Web\Model\Api\NewPost;
use Web\Model\Purchases;
use Web\Model\Settings\BasicModel;

class Update extends BasicModel
{
    /**
     * @param $post
     * @param $bean
     * @return \RedBeanPHP\OODBBean
     */
    public function create_return_shipping($post, $bean)
    {
        if (empty($bean)) {
            $sql = "INSERT INTO return_shipping SET order_id = ?, type = 'none'";
            R::exec($sql, [$post->id]);
            return R::findOne('return_shipping', '`order_id` = ?', [$post->id]);
        } else {
            return $bean;
        }
    }

    /**
     * @param $post
     */
    public function return_shipping($post)
    {
        $bean = R::findOne('return_shipping', '`order_id` = ?', [$post->id]);
        $bean = $this->create_return_shipping($post, $bean);

        $id = $post->id;
        unset($post->id);

        $history = [];
        foreach ($post as $k => $v) {
            if ($bean->$k != $v) {
                $history[$k] = $v;
            }
            $bean->$k = $v;
        }

        if (count($history) > 0) {
            $this->save_changes_log('update_return_shipping', json_encode($history), $id);
        }

        R::store($bean);

        response(200, 'Дані вдало оновлено!');
    }

    /**
     * @param $post
     */
    public function contact($post)
    {
        $bean = R::load('orders', $post->id);
        $id = $post->id;
        unset($post->id);

        $history = [];
        foreach ($post as $k => $v) {
            if ($bean->$k != $v) {
                $history[$k] = $v;
            }
            $bean->$k = $v;
        }

        if (count($history) > 0) {
            $this->save_changes_log('update_contact', json_encode($history), $id);
        }
        R::store($bean);

        response(200, 'Дані успішно оновлені');
    }

    /**
     * @param $post
     */
    public function working($post, $id)
    {
        $bean = R::load('orders', $id);

        $history = [];

        if (isset($post->courier)) {
            if ($bean->courier != $post->courier) {
                $courier = parent::getOne($post->courier, 'couriers');
                $history['courier'] = $courier->name;
            }
        }

        if (isset($post->delivery)) {
            if ($bean->delivery != $post->delivery) {
                $delivery = parent::getOne($post->delivery, 'logistics');
                $history['delivery'] = $delivery->name;
            }
        }

        if (isset($post->hint)) {
            if ($bean->hint != $post->hint) {
                $hint = parent::getOne($post->hint, 'colors');
                $history['hint'] = '<span style="color: #' . $hint->color . '">' . $hint->description . '</span>';
            }
        }

        $arr = ['date_delivery', 'comment', 'coupon', 'time_with', 'time_to'];

        foreach ($arr as $k) {
            if (isset($post->$k)) {
                if ($bean->$k != $post->$k) {
                    $history[$k] = $post->$k;
                }
            }
        }

        foreach ($post as $k => $v){
            if ($k == 'time_with' || $k == 'time_to')
                $bean->$k = time_to_string($v);
            else
                $bean->$k = $v;
        }

        $this->save_changes_log('update_working', json_encode($history), $id);

        R::store($bean);

        response(200, 'Дані успішно оновлено!');
    }

    /**
     * @param $post
     */
    public function status($post)
    {
        $bean = R::load('orders', $post->id);
        $bean->status = $post->status;
        R::store($bean);

        $statuses = OrderSettings::statuses($bean->type);
        $data = 'Новий статус: "' . $statuses[$post->status]->text . '"';
        $this->save_changes_log('update_status', $data, $post->id);

        response(200, 'Статус вдало оновлено!');

    }

    /**
     * @param $type
     * @param $data
     * @param $id
     */
    public function save_changes_log($type, $data, $id)
    {
        $bean = R::dispense('changes');

        $bean->data = $data;
        $bean->id_order = $id;
        $bean->type = $type;
        $bean->date = date('Y-m-d h:i:s');
        $bean->author = user()->id;

        R::store($bean);
    }

    /**
     * @param $post
     * @param $id
     */
    public function address($post, $id)
    {
        $bean = R::load('orders', $id);

        $history = [];

        if ($bean->type == 'sending') {
            $delivery_company = R::load('logistics', $bean->delivery);
            if($delivery_company->name == 'НоваПошта') {
                $history = $this->history_address($bean, $post);
            }
        }

        if (isset($post->address)) {
            if ($bean->address != $post->address) {
                $history['address'] = $post->address;
            }
        }

        foreach ($post as $k => $v)
            $bean->$k = $v;

        $this->save_changes_log('update_address', json_encode($history), $id);

        R::store($bean);

        response(200, 'Дані вдало оновлені!');
    }

    /**
     * @param $bean
     * @param $data
     * @return array
     */
    public function history_address($bean, $data)
    {
        $history = [];
        $new_post = new NewPost();

        if ($bean->city != $data->city) {
            $history['city'] = $new_post->getNameCityByRef($data->city);
        }

        $warehouses = $new_post->search_warehouses($data->city);
        foreach ($warehouses['data'] as $warehouse) {
            if ($warehouse['Ref'] == $data->warehouse) {
                $history['warehouse'] = $warehouse['Description'];
                break;
            }
        }

        return $history;
    }

    /**
     * @param $post
     * @param $id
     */
    public function pay($post, $id)
    {
        $bean = R::load('orders', $id);
        $history = [];

        if (isset($post->pay_method)) {
            if ($bean->pay_method != $post->pay_method) {
                $pay = R::load('pays', $post->pay_method);
                $history['pay_method'] = $pay->name;
                $bean->pay_method = $post->pay_method;
            }
        }

        $arr = ['form_delivery', 'pay_delivery', 'imposed', 'payment_status', 'prepayment'];

        foreach ($arr as $k) {
            if (isset($post->$k)) {
                if ($bean->$k != $post->$k) {
                    $history[$k] = $post->$k;
                }
                $bean->$k = $post->$k;
            }
        }

        $this->save_changes_log('update_pay', json_encode($history), $id);

        R::store($bean);

        response(200, 'Дані успішно оновлено!');
    }

    /**
     * @param $products
     * @param $data
     * @param $id
     */
    public function products($products, $data, $order_id)
    {
        foreach ($products as $product) {
            if ($product->pto != 0) {
                $this->update_product($product->pto, $product);
            } else {
                $this->add_product($product->id, $order_id, $product);
            }
        }

        $history = [];
        $bean = R::load('orders', $order_id);

        foreach ($data as $k => $v) {
            if ($bean->$k != $v) {
                $history[$k] = $v;
            }
            $bean->$k = $v;
        }

        if (my_count($history) > 0) {
            $this->save_changes_log('update_price', json_encode($history), $order_id);
        }

        R::store($bean);
        response(200, 'Дані успішно оновлені!');
    }

    /**
     * @param $product_id
     * @param $order_id
     * @param $product
     */
    private function update_product($pto, $product)
    {
        $bean = R::load('product_to_order', $pto);
        $count_in_order = $bean->amount;
        $amount = $product->amount;
        $history = [];

        if ($product->amount != $bean->amount) {
            $p_bean = R::load('products', $product->id);
            $p_bean->count_on_storage = $p_bean->count_on_storage + $bean->amount - $product->amount;
            $this->create_purchase($p_bean); // create purchase if count on storage <= 2
            R::store($p_bean);

            $history['amount'] = $product->amount;
            $bean->amount = $product->amount;
        }

        if (isset($product->place)) {
            if ($product->place != $bean->place) {
                $history['place'] = $product->place;
                $bean->place = $product->place;
            }
        }

        if ($product->price != $bean->price) {
            $history['price'] = $product->price;
            $bean->price = $product->price;
        }

        if (isset($product->attributes)) {
            if ($product->attributes != $bean->attributes) {
                $history['attributes'] = $product->attributes;
                $bean->attributes = json_encode($product->attributes);
            }
        }

        if (my_count($history) > 0) {
            $this->history_product('update_product_in_order', json_encode($history), $product->id);
            $history['order'] = $bean->order_id;
            $this->save_changes_log('update_product_info', json_encode($history), $bean->order_id);
        }

        R::store($bean);

        $bean = R::load('products', $product->id);

        if ($bean->type_product == 'combine') {
            $linked = R::getAll('SELECT * FROM `combine_product` WHERE `product_id` = ?', [$product->id]);
            foreach ($linked as $product) {
                $bean2 = R::load('products', $product['linked_id']);
                $bean2->count_on_storage = ($bean2->count_on_storage + ($count_in_order * $product['combine_minus'])) - ($product['combine_minus'] * $amount);
                R::store($bean2);
            }
        }
    }

    /**
     * @param $p_bean
     */
    private function create_purchase($p_bean)
    {
        if ($p_bean->count_on_storage <= 2) {
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

    /**
     * @param $product_id
     * @param $order_id
     * @param $product
     */
    private function add_product($product_id, $order_id, $product)
    {
        $bean = R::xdispense('product_to_order');

        $bean->order_id = $order_id;
        $bean->product_id = $product_id;
        $bean->attributes = isset($product->attributes) ? json_encode($product->attributes) : '{}';
        $bean->price = $product->price;
        $bean->amount = $product->amount;
        if (isset($product->place)) $bean->place = $product->place;

        R::store($bean);

        $bean = R::load('products', $product_id);

        if ($bean->type_product == 'combine') {
            $linked = R::getAll('SELECT * FROM `combine_product` WHERE `product_id` = ?', [$product_id]);
            foreach ($linked as $p) {
                $bean2 = R::load('products', $p['linked_id']);
                $bean2->count_on_storage = $bean2->count_on_storage - ($p['combine_minus'] * $product->amount);
                R::store($bean2);
            }
        }

        $bean->count_on_storage = $bean->count_on_storage - $product->amount;
        $this->create_purchase($bean); // create purchase if count on storage <= 2

        $product->id = $product_id;
        $product->name = $bean->name;
        $this->save_changes_log('add_product', json_encode($product), $order_id);

        $product->id = $order_id;
        unset($product->name);
        $this->history_product('add_product_to_order', json_encode($product), $product_id);

        R::store($bean);
    }

    /**
     * @param $product_id
     * @param $data
     * @param $type
     */
    private function history_product($type, $data, $product_id)
    {
        $bean = R::xdispense('history_product');

        $bean->product = $product_id;
        $bean->type = $type;
        $bean->data = $data;
        $bean->date = date('Y-m-d h:i:s');
        $bean->author = user()->id;

        R::store($bean);
    }

}