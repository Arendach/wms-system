<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\Coupon;
use Web\Model\Purchases;

class PurchasesController extends Controller
{
    /**
     * @GET
     */
    public function index()
    {
        $items = Purchases::get_all();
        $sum = 0;
        foreach ($items as $item) $sum += $item->sum;

        $data = [
            'title' => 'Замовлення :: Закупки',
            'components' => ['breadcrumbs'],
            'items' => $items,
            'sum' => $sum,
            'scripts' => ['purchases.js'],
            'manufacturers' => Purchases::getAll('manufacturers')
        ];

        $this->view->display('/purchases/index', $data);
    }

    /**
     * @GET
     */
    public function create()
    {
        $data = [
            'title' => 'Закупки :: Створення',
            'components' => ['breadcrumbs'],
            'manufacturers' => Purchases::getAll('manufacturers'),
            'scripts' => ['purchases.js'],
            'categories' => Coupon::getCategories(),
            'opened' => Purchases::getOpenPurchases(),
            'css' => [style('purchases')]
        ];

        $this->view->display('/purchases/create', $data);
    }

    /**
     * @param $post
     */
    public function post_create($post)
    {
        if (!isset($post->products) || my_count($post->products) == 0)
            response(400, 'Виберіть хоча-б один товар!');

        Purchases::create($post);
    }

    /**
     * @GET
     * @param $id
     */
    public function update($id)
    {
        $purchases = Purchases::getOne($id);

        if ($purchases->id == 0) $this->display_404();

        $data = [
            'title' => 'Закупки :: Редагування',
            'components' => ['breadcrumbs', 'sweet_alert', 'modal'],
            'items' => Purchases::getProductsByPurchasesID($id),
            'to_js' => ['id' => $id, 'manufacturer' => $purchases->manufacturer],
            'scripts' => ['purchases.js'],
            'css' => [style('purchases')],
            'categories' => Coupon::getCategories(),
            'purchases' => Purchases::getOne($id)
        ];

        $this->view->display('/purchases/update', $data);
    }

    /**
     * @param $post
     */
    public function searchProducts($post)
    {
        if (!isset($post->manufacturer) || empty($post->manufacturer))
            response(400, 'Виберіть виробника!');
        if (!isset($post->field) || empty($post->field))
            response(400, 'Error!');
        if (!isset($post->data) || empty($post->data))
            response(400, 'Введіть дані!');

        $data = [
            'items' => Purchases::searchProducts($post)
        ];

        $this->view->display('/purchases/products', $data);
    }

    /**
     * @param $post
     */
    public function post_update($post)
    {
        if (empty($post->data['products']))
            response(400, 'Виберіть товар!');

        $comment = isset($post->data['comment']) ? $post->data['comment'] : '';
        Purchases::update_products($post->id, $post->data['products'], $post->data['sum'], $comment);
    }

    /**
     * @param $id
     */
    public function print_($id)
    {
        $data = [
            'data' => Purchases::getToPrint($id)
        ];

        $this->view->display('/purchases/print', $data);
    }

    /**
     * @param $post
     */
    public function update_info($post)
    {
        if ($post->data['status'] == 1) {
            if (empty($post->data['prepayment']) || $post->data['prepayment'] == 0)
                response('400', 'Введіть суму предоплати!');
            Purchases::prepayment_control_money($post->data['prepayment'], $post->id);
        }
        Purchases::update($post->data, $post->id);

    }

    /**
     * @param $post
     */
    public function close_form($post)
    {
        $data = [
            'item' => Purchases::getToPrint($post->id),
            'title' => 'Заповніть дані для звіту!'
        ];

        echo $this->view->render('/purchases/close_form', $data);
    }

    /**
     * @param $post
     */
    public function close($post)
    {
        if (empty($post->name_operation))
            response('400', 'Заповніть назву операції!');

        Purchases::close($post);
    }

    /**
     * @param $post
     */
    public function getProducts($post)
    {
        if (!isset($post->products) || empty($post->products))
            response('400', 'Виберіть хоча-б один товар!');

        $data = ['items' => Purchases::getProducts($post->products)];

        echo $this->view->render('/purchases/get_products', $data);
    }
}