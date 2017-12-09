<?php

namespace Web\Controller;

use Web\Model\ClientsGroup;
use Web\App\Controller;

class ClientsGroupController extends Controller
{
    /**
     * @GET
     * Перегляд груп клієнтів
     */
    public function index()
    {
        $data = [
            'title' => 'Групи клієнтів',
            'groups' => ClientsGroup::getAll(),
            'script' => 'clients/groups.js',
            'components' => ['sweet_alert', 'modal', 'breadcrumbs']
        ];

        $this->view->display('/clients/groups/index', $data);
    }

    /**
     * @POST
     * @param $data
     * Збереження нової гупи
     */
    public function create($data)
    {
        $id = ClientsGroup::createGroup($data);
        res(['status' => '1', 'id' => $id]);
    }

    /**
     * @POST
     * @param $data
     */
    public function get_form($data)
    {
        $forms = [
            'create' => ['method' => 'create_form', 'data' => false],
            'update' => ['method' => 'update_form', 'data' => true]
        ];
        if (!isset($data->form)) {
            response(400, 'Не правильні вхідні параметри!');
        } else {
            if (isset($forms[$data->form])) {
                $method_name = $forms[$data->form]['method'];
                if ($forms[$data->form]['data'] == true) {
                    $this->$method_name($data->data);
                } else {
                    $this->$method_name();
                }
            }
        }
    }

    /**
     * @param $data
     * Форма редагування
     */
    public function update_form($data)
    {
        echo $this->view->render('/clients/forms/edit_group', ['group' => ClientsGroup::getOne($data['id'])]);
    }

    /**
     * Форма створення
     */
    public function create_form()
    {
        echo $this->view->render('/clients/forms/create_group');
    }

    /**
     * @POST
     * @param $data
     * Збереження змін в базі даних
     */
    public function edit($post)
    {
        $id = $post->id;
        unset($post->id);
        ClientsGroup::update($post, $id);
}

    /**
     * @POST
     * Видалення групи
     */
    public function delete($data)
    {
        ClientsGroup::delete($data->id);
    }

}