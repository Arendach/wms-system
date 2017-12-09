<?php

namespace Web\Controller\Orders;

use Web\App\Controller;
use Web\Model\Api\NewPost;
use Web\Model\Orders\PrintModel;

class PrintController extends Controller
{
    /**
     * Обробник роута
     * @param $id
     */
    public function handle($id)
    {
        if (get('type') == 'invoice') {
            $this->invoice($id);
        } elseif (get('type') == 'sales_invoice') {
            $this->sales_invoice($id);
        } else {
            $this->receipt($id);
        }
    }

    /**
     * Роздруковка товарного чеку
     * @param $id
     */
    public function receipt($id)
    {
        $order = PrintModel::getOne($id);
        $products = PrintModel::getProducts($id);
        $data = [
            'order' => $order,
            'id' => $id,
            'type' => $order->type,
            'products' => $products->products,
            'sum' => $products->sum,
            'places' => $products->places
        ];

        if ($order->type == 'delivery') {
            preg_match('/^([А-я]+)(.*)\(([А-я\']+)\)$/u', $order->street, $matches);
            $data['street_type'] = isset($matches[1]) ? $matches[1] : 'Вулиця';
            $data['street'] = isset($matches[2]) ? $matches[2] : 'Не заповнено';
            $data['region'] = isset($matches[3]) ? $matches[3] : 'Не заповнено';
        } elseif ($order->type == 'sending') {
            $data['order']['delivery_name'] = PrintModel::getDeliveryName($order->delivery);
            if ($data['order']['delivery_name'] == 'НоваПошта') {
                $new_post = new NewPost();
                $address = $new_post->get_address($order->city, $order->warehouse);
                $data['order']['city'] = $address['city'];
                $data['order']['warehouse'] = $address['warehouse'];
            }
            $data['pay'] = PrintModel::getPay($id);
        }

        $this->view->display('/orders/print/receipt', $data);
    }

    /**
     * Роздруковка рахунку фактури
     * @param $id
     */
    public function invoice($id)
    {
        $data = [
            'id' => $id,
            'products' => PrintModel::getProducts($id),
            'order' => PrintModel::getOne($id)
        ];

        $this->view->display('/orders/print/invoice', $data);
    }

    /**
     * Роздруковка видаткової накладної
     * @param $id
     */
    public function sales_invoice($id)
    {
        $order = PrintModel::getOne($id);

        $data = [
            'id' => $id,
            'products' => PrintModel::getProducts($id),
            'order' => $order
        ];

        $this->view->display('/orders/print/sales_invoice', $data);
    }
}