<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\Clients;
use Web\Model\ClientsGroup;

class ClientsController extends Controller
{
    /**
     * Клієнтів на екран
     */
    public function index()
    {
        $getClients = Clients::getClients();
        $data = [
            'title' => 'Продажі :: Постійні клієнти',
            'script' => 'clients/clients.js',
            'components' => ['modal', 'sweet_alert', 'jquery', 'summer_note', 'breadcrumbs'],
            'clients' => $getClients['clients'],
            'paginate' => $getClients['paginate']
        ];
        $this->view->display('/clients/index', $data);
    }

    /**
     * Віддати форму
     */
    public function get_form($data)
    {
        if (val($data->form))
            $form = $data->form;
        else
            response(400, 'Не правильні вхідні параметри!');

        $method_name = $form . '_form';
        $class = new ClientsController();

        if (!method_exists($class, $method_name)) {
            $message = 'Сталась внутрішня помилка сервера! FILE => ' . __FILE__ . ' LINE => ' . __LINE__;
            response(501, $message);
        } else {
            if (isset($data->data))
                $this->$method_name($data->data);
            else
                $this->$method_name();
        }
    }

    /**
     * Форма прикріплення замовлення
     */
    public function add_order_form()
    {
        echo $this->view->render('/clients/forms/add_order', []);
    }

    /**
     * Форма створення клієнта
     */
    public function create_form()
    {
        $data['groups'] = ClientsGroup::getAll();
        echo $this->view->render('/clients/forms/create_client', $data);
    }

    /**
     * Форма редагування клієнта
     */
    public function edit_form($post)
    {
        $data = [
            'groups' => ClientsGroup::getAll(),
            'client' => Clients::getClient($post['id'])
        ];

        echo $this->view->render('/clients/forms/edit_client', $data);
    }

    /**
     * Створення нового клієнта
     */
    public function create($data)
    {
        Clients::insert($data);
    }

    /**
     * Оновлення даних клієнта
     */
    public function update($post)
    {
        Clients::update($post->data, $post->id);
    }

    /**
     * Видалення клієнта з бази даних
     */
    public function delete($data)
    {
        Clients::delete($data->id);
    }

    /**
     * Перегляд замовлень клієнта
     */
    public function get_orders($id)
    {
        $data = [
            'title' => 'Замовлення клієнта',
            'orders' => Clients::getOrders($id),
            'script' => 'clients/orders.js',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'client_id' => $id
        ];

        $this->view->display('/clients/orders', $data);
    }

    /**
     * Видалити замовлення від клієнта
     */
    public function order_remove($data)
    {
        Clients::order_remove($data);
    }

    /**
     * Пошук замовлень
     */
    public function search_order($data)
    {
        $array = Clients::getOrdersByClient($data->client);
        $new_array = [];
        foreach ($array as $item)
            $new_array[] = $item['order_id'];
        $orders = Clients::search_order($data);
        $arr = [];
        foreach ($orders as $k => $item)
            if (!in_array($item->id, $new_array))
                $arr[$k] = $item;

        echo $this->view->render('/clients/forms/search_result', ['data' => $arr]);
    }

    /**
     * Прикріплення замовлення для клієнта
     */
    public function save_orders($data)
    {
        Clients::save_orders($data);
    }
}