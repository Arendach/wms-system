<?php

namespace Web\Controller;

use Web\App\Validator;
use Web\Model\ManufacturersGroup;
use Web\App\Controller;

class ManufacturerGroupsController extends Controller
{
    /**
     * @GET
     * Всі групи на екран
     */
    public function index()
    {
        $data = [
            'title' => 'Каталог :: Групи виробників',
            'script' => 'manufacturer_groups.js',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'section' => 'Групи виробників',
            'groups' => ManufacturersGroup::getAll()
        ];

        $this->view->display('/manufacturer/groups/index', $data);
    }

    /**
     * @POST
     * Обробник форми
     */
    public function get_form($post)
    {
        if ($post->form == 'update') {
            $this->update_form($post);
        } elseif ($post->form == 'create') {
            $this->create_form();
        }
    }

    /**
     * @POST
     * Віддаємо форму оновлення
     */
    public function update_form($post)
    {
        $data = [
            'title' => 'Редагування групи',
            'group' => ManufacturersGroup::getOne($post->id)
        ];
        $this->view->display('/modal/manufacturer/groups/update', $data);
    }

    /**
     * @POST
     * Віддаємо форму для створення
     */
    public function create_form()
    {
        $this->view->display('/modal/manufacturer/groups/add', ['title' => 'Нова група виробників']);
    }

    /**
     * @POST
     * Зберігаємо дані в базі
     */
    public function create($post)
    {
        $rules = ['sort' => 'integer', 'name' => 'string'];
        $messages = ['sort' => 'Заповніть сортування!', 'name' => 'Заповніть імя!'];
        Validator::run($post, $rules, $messages);
        if (Validator::status())
            ManufacturersGroup::insert($post);
        else
            echo Validator::errors();
    }

    /**
     * @POST
     * Оновляємо дані в базі
     */
    public function update($post)
    {
        $rules = ['sort' => 'integer', 'name' => 'string'];
        $messages = ['sort' => 'Заповніть сортування!', 'name' => 'Заповніть імя!'];
        Validator::run($post, $rules, $messages);
        if (Validator::status())
            ManufacturersGroup::update($post, $post->id);
        else
            echo Validator::errors();
    }

    /**
     * @POST
     * Видаляємо групу з бази даних
     */
    public function delete($post)
    {
        ManufacturersGroup::delete($post->id);
    }
}

?>