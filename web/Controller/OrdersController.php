<?php

namespace Web\Controller;

use Web\Model\Category;
use Web\Model\Coupon;
use Web\Model\Orders;
use Web\App\Controller;
use Web\Model\OrderSettings;
use Web\Model\Products;
use Web\Model\Api\NewPost;

class OrdersController extends Controller
{
    /**
     * @GET
     */
    public function index()
    {
        $data = [
            'title' => 'Продажі :: Замовлення',
            'script' => 'orders/view.js',
            'section' => 'Замовлення',
            'components' => ['breadcrumbs'],
            'route' => true
        ];

        $this->view->display('/buy/index', $data);
    }

    /**
     * @GET
     * Перегляд замовлень
     */
    public function view_orders($type)
    {
        $order = Orders::orderDataByType($type);

        $content = [
            'data' => get_object($order['data']),
            'type' => $type
        ];

        $data = [
            'title' => 'Замовлення',
            'scripts' => ['orders/order.js', 'orders/view.js'],
            'components' => ['breadcrumbs'],
            'type' => $type,
            'css' => [
                style('orders/common')
            ],
            'paginate' => $order['paginate'],
            'content' => $this->view->render('/buy/table_orders', $content)
        ];

        $this->view->display('/buy/view', $data);
    }

    /**
     * @GET
     * Додати нове замовлення
     */
    public function create_order($type)
    {
        $data = [
            'title' => 'Нове замовлення',
            'components' => ['sweet_alert', 'breadcrumbs'],
            'scripts' => ['orders/order.js', 'orders/add.js'],
            'categories' => Coupon::getCategories(),
            'type' => $type,
            'hints' => Orders::getAll('colors'),
            'pays' => OrderSettings::getAll('pays'),
            'couriers' => OrderSettings::getAll('couriers'),
            'deliveries' => OrderSettings::getAll('logistics'),
            'to_js' => [
                'type' => $type
            ]
        ];

        if ($type == 'sending') {
            $data['scripts'][] = 'orders/sending.js';
        } elseif ($type == 'shop') {
            $data['address'] = 'Бориспільська 26 \'З\', магазин \'Повітряно\'';
        } elseif ($type == 'delivery') {
            $data['scripts'][] = 'orders/delivery.js';
        }

        $this->view->display('/buy/add', $data);
    }

    /**
     * @GET
     * Редагування замовлення
     */
    public function edit($id)
    {
        $order = Orders::getOrderById($id);

        $data = [
            'title' => 'Редагування замовлення',
            'components' => ['sweet_alert', 'breadcrumbs'],
            'scripts' => ['orders/order.js', 'orders/edit.js', 'orders/update.js'],
            'id' => $id,
            'type' => $order->type,
            'products' => Orders::getProductsByOrderId($id),
            'pays' => OrderSettings::getAll('pays'),
            'couriers' => OrderSettings::getAll('couriers'),
            'deliveries' => OrderSettings::getAll('logistics'),
            'order' => $order,
            'hints' => Orders::getAll('colors'),
            'categories' => Coupon::getCategories(),
            'to_js' => [
                'id' => $id,
                'type' => $order->type,
                'discount' => $order->discount,
                'delivery_cost' => $order->delivery_cost
            ]
        ];

        if ($order->type == 'sending') {
            if ($order->logistic_name == 'НоваПошта') {
                $new_post = new NewPost();
                $order->city_name = $new_post->getNameCityByRef($order->city);
                $data['warehouses'] = $new_post->search_warehouses($order->city);
                $data['return_shipping'] = Orders::get_return_shipping($data['id']);
                $data['cards'] = $new_post->get_cards();
            } else {
                $data['return_shipping'] = Orders::get_return_shipping($data['id']);
                $data['cards'] = [];
            }
            $data['scripts'][] = 'orders/sending.js';
        } elseif ($order->type == 'delivery') {
            $data['scripts'][] = 'orders/delivery.js';
        }

        $this->view->display('/buy/edit', $data);
    }

    /**
     * @POST
     * Видалення товару із замовлення
     */
    public function drop_product($data)
    {
        Orders::drop_product($data);
    }

    /**
     * @POST
     * Новий товар у замовленню
     */
    public function get_product_by_id($data)
    {
        $products = get_object(Orders::get_product_by_id($data));
        echo $this->view->render('/buy/edit/list_order', ['products' => $products, 'type' => $data->type]);
    }

    /**
     * @GET
     * Перегляд історії змін для певного замовлення
     */
    public function changes($id)
    {
        $data = [
            'order' => Orders::getOne($id),
            'title' => 'Історія змін замовлення',
            'section' => 'Історія змін замовлення',
            'components' => ['breadcrumbs'],
            'changes' => Orders::get_changes_by_id($id),
            'id' => $id
        ];

        $this->view->display('/buy/changes', $data);
    }

    /**
     * @GET
     * @param $id
     * Перегляд замовлення
     */
    public function view_order($id)
    {
        $data = [
            'title' => 'Замовлення №' . $id,
            'scripts' => ['orders/order.js', 'orders/view.js'],
            'link_css' => ['print/order.css'],
            'section' => 'Замовлення №' . $id,
            'data' => Orders::getOrder($id),
            'products' => Orders::getProductsByOrderId($id)
        ];

        $this->view->display('/orders/view', $data);
    }

    /**
     * @POST
     * @param $data
     * Пошук товарів у БД
     */
    public function search_products($data)
    {
        $where = '';
        $return = '';
        foreach ($data as $key => $value) {
            if ($key == 'category_id')
                $where .= " `category` = '$value' ";
            else if ($key == 'name')
                $where .= " `name` LIKE '%$value%' ";
            else
                $where .= " `$key` LIKE '%$value%' ";
        }
        $where = str_replace('\'`', '\', `', $where);

        foreach (Products::search($where) as $product)
            $return .= '<option value="' . $product['id'] . '">' . $product['name'] . ' | ' . $product['identefire_storage'] . '</option>';
        echo $return;
    }

    /**
     * @GET
     * @PRINT
     * Роздруковка замовлення
     */
    public function print_order($id)
    {
        $data = [
            'order' => Orders::getOne($id),
            'products' => Orders::getProductsByOrderId($id),
            'link_css' => '/css/print/order.css'
        ];

        $this->view->display('/buy/print', $data);
    }

    /**
     * @GET
     */
    public function change_type()
    {
        if (get('type') && get('id')) {
            if (get('type') != 'delivery' && get('type') != 'self') {
                $this->display_404();
            }
            Orders::change_type(get('type'), get('id'));
        } else {
            $this->display_404();
        }
    }
}

