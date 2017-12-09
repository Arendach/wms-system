<?php

namespace Web\Model\Orders;

use Web\Model\Purchases;
use Web\Model\Settings\BasicModel;
use RedBeanPHP\R;
use Web\Model\Api\NewPost;

class Create extends BasicModel
{
    /**
     * Table
     */
    const table = 'orders';

    /**
     * @param $data
     * @param $products
     * @param $return_shipping
     */
    public function sending($data, $products, $return_shipping)
    {
        $user = user();
        $date = date('Y-m-d h:i:s');

        $bean = R::dispense('orders');

        foreach ($data as $k => $v) $bean->$k = $v;
        $bean->date = $date;
        $bean->author = $user->id;

        $id = R::store($bean);

        $this->return_shipping($return_shipping, $id);
        $this->products($products, $id, $user);
        $this->changes($data, $products, $user, $id, $return_shipping);

        response(200, 'Всі дані успішно збережено!');
    }

    /**
     * @param $data
     * @return mixed
     */
    private function prepare_city($data)
    {
        if (isset($data->city)) {
            $new_post = new NewPost();
            if (!isset($data->warehouse)) {
                $data->city = $new_post->getNameCityByRef($data->city);
            } else {
                $temp = $new_post->get_address($data->city, $data->warehouse);
                $data->city = $temp['city'];
                $data->warehouse = $temp['warehouse'];
            }
        }

        return $data;
    }

    /**
     * @param $data
     * @param $products
     * @param $user
     * @param $id
     * @param bool $return_shipping
     */
    private function changes($data, $products, $user, $id, $return_shipping = false)
    {
        $delivery_company = R::load('logistics', $id);
        if($delivery_company->name == 'НоваПошта') {
            $data = $this->prepare_city($data);
        }
        $data = $this->unset_empty_pay($data);
        $data = $this->replace_fields_table($data);
        $data = $this->replace_fields_value($data);
        $data = $this->replace_hint($data);
        $data = $this->data_part($data);
        $data->products = $this->prepare_products($products);
        if ($return_shipping !== false) {
            $data->return_shipping = $this->prepare_return_shipping($return_shipping);
            $data->return_shipping = $this->unset_empty($return_shipping);
        }

        $bean = R::dispense('changes');

        $bean->data = json_encode($data);
        $bean->id_order = $id;
        $bean->type = 'original';
        $bean->date = date('Y-m-d h:i:s');
        $bean->author = $user->id;

        R::store($bean);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function unset_empty_pay($data)
    {
        if (isset($data->form_delivery) && $data->form_delivery == 'imposed') {
            unset($data->imposed);
        }

        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function unset_empty($data)
    {
        if (isset($data->type) && $data->type == 'none') {
            unset($data->type_remittance);
            unset($data->card);
            unset($data->sum);
            unset($data->payer);
        } else {
            if ($data->type_remittance == 'imposed') {
                unset($data->card);
            }
        }

        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function data_part($data)
    {
        $arr = [
            'address' => ['city', 'warehouse'],
            'contact' => ['fio', 'phone', 'phone2', 'email'],
            'pay' => ['form_delivery', 'imposed', 'pay_delivery', 'payment_status'],
            'working' => ['hint', 'delivery', 'date_delivery', 'courier', 'coupon', 'comment'],
        ];

        foreach ($arr as $key => $fields) {
            $data->$key = new \stdClass();
            foreach ($fields as $field) {
                if (isset($data->$field)) {
                    $data->$key->$field = $data->$field;
                    unset($data->$field);
                }
            }
        }

        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function prepare_return_shipping($data)
    {
        return $data;
    }

    /**
     * @param $products
     * @return mixed
     */
    private function prepare_products($products)
    {
        foreach ($products as $id => $value) {
            $temp = R::load('products', $id);
            $products->$id->name = $temp->name;
        }

        return $products;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function replace_hint($data)
    {
        if (isset($data->hint)) {
            $temp = R::load('colors', $data->hint);
            $data->hint = '<span style="color: #' . $temp->color . '">' . $temp->description . '</span>';
        }

        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function replace_fields_value($data)
    {
        $arr = [
            'payment_status' => [
                ['0' => 'Не оплачено'],
                ['1' => 'Олачено']
            ],
            'imposed' => [
                ['sender' => 'Відправник'],
                ['recipient' => 'Отримувач']
            ],
            'pay_delivery' => [
                ['sender' => 'Відправник'],
                ['recipient' => 'Отримувач']
            ],
            'form_delivery' => [
                ['imposed' => 'Наложений платіж'],
                ['on_the_card' => 'Безготівкова']
            ]
        ];

        foreach ($arr as $key => $value) {
            if (isset($data->$key)) {
                foreach ($value as $k => $v) {
                    if ($data->$key == $k) {
                        foreach ($v as $k1 => $v2) {
                            $data->$key = $v2;
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function replace_fields_table($data)
    {
        $arr = ['courier' => 'couriers', 'region' => 'regions', 'pay_method' => 'pays', 'delivery' => 'logistics'];

        foreach ($arr as $key => $table) {
            if (isset($data->$key)) {
                $temp = R::load($table, $data->$key);
                $data->$key = $temp->name;
            }
        }

        return $data;
    }

    /**
     * @param $products
     * @param $id
     */
    private function products($products, $id, $user)
    {
        foreach ($products as $product) {
            $product->attributes = isset($product->attributes) ? json_encode($product->attributes) : '{}';

            $this->history_product($product, $product->id, $id, $user);
            $this->product_warehouse($product->id, $product->amount);

            $bean = R::xdispense('product_to_order');

            $bean->order_id = $id;
            $bean->product_id = $product->id;

            unset($product->order);
            unset($product->id);
            foreach ($product as $key => $value)
                $bean->$key = $value;

            R::store($bean);
        }
    }

    /**
     * @param $product_id
     * @param $amount
     */
    private function product_warehouse($product_id, $amount)
    {
        $bean = R::load('products', $product_id);
        $bean->count_on_storage = $bean->count_on_storage - $amount;
        $this->create_purchase($bean);
        R::store($bean);
    }

    /**
     * @param $data
     * @param $product_id
     * @param $order_id
     * @param $user
     */
    private function history_product($data, $product_id, $order_id, $user)
    {
        $bean = R::xdispense('history_product');

        $temp = $data;
        $temp->order = $order_id;
        if (isset($data->place)) $temp->place = $data->place;

        $bean->product = $product_id;
        $bean->type = 'add_to_order';
        $bean->data = json_encode($temp);
        $bean->date = date('Y-m-d h:i:s');
        $bean->author = $user->id;

        R::store($bean);
    }

    /**
     * @param $data
     * @param $id
     */
    private function return_shipping($data, $id)
    {
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        $bean = R::xdispense('return_shipping');

        foreach ($data as $key => $value)
            $bean->$key = $value;

        $bean->order_id = $id;

        R::store($bean);
    }

    /**
     * @param $post
     */
    public function self($data, $products)
    {
        $user = user();
        $date = date('Y-m-d h:i:s');

        $bean = R::dispense('orders');

        foreach ($data as $k => $v) $bean->$k = $v;
        $bean->date = $date;
        $bean->author = $user->id;

        $id = R::store($bean);

        $this->products($products, $id, $user);
        $this->changes($data, $products, $user, $id);

        response(200, 'Всі дані успішно збережено!');
    }

    /**
     * @param $post
     */
    public function delivery($data, $products)
    {
        $user = user();
        $date = date('Y-m-d h:i:s');

        $bean = R::dispense('orders');

        foreach ($data as $k => $v) {
            if ($k == 'time_with' || $k == 'time_to')
                $bean->$k = time_to_string($v);
            else
                $bean->$k = $v;
        }

        $bean->date = $date;
        $bean->author = $user->id;

        $id = R::store($bean);

        $this->products($products, $id, $user);
        $this->changes($data, $products, $user, $id);

        response(200, 'Всі дані успішно збережено!');
    }

    /**
     * @param $post
     */
    public function shop($data, $products)
    {
        $user = user();
        $date = date('Y-m-d h:i:s');

        $bean = R::dispense('orders');

        foreach ($data as $k => $v) $bean->$k = $v;
        $bean->date = $date;
        $bean->author = $user->id;

        $id = R::store($bean);

        $this->products($products, $id, $user);
        $this->changes($data, $products, $user, $id);

        response(200, 'Всі дані успішно збережено!');
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
}