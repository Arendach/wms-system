<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\App\Validator;
use Web\Model\Storage;

class StorageController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Каалог :: Склади',
            'section' => 'Склади',
            'scripts' => ['storage.js'],
            'components' => ['modal', 'sweet_alert', 'breadcrumbs', 'summer_note'],
            'storage' => Storage::getAll()
        ];

        $this->view->display('/storage/index', $data);
    }

    public function get_form($post)
    {
        $forms = ['create', 'update'];
        $data = isset($post->data) ? $post->data : '';
        if (isset($post->form) && in_array($post->form, $forms)) {
            $method_name = 'form_' . $post->form;
            $this->$method_name(get_object($data));
        }
    }

    public function form_create($post)
    {
        $this->access_check('storage_create');
        $this->view->display('/modal/storage/add', ['title' => 'Новий склад']);
    }

    public function form_update($post)
    {
        $this->access_check('storage_update');

        $data = [
            'title' => 'Оновити склад',
            'storage' => Storage::getOne($post->id),
        ];
        $this->view->display('/modal/storage/update', $data);
    }

    public function delete($post)
    {
        Storage::delete($post->id);
    }

    public function create($post)
    {
        unset($post->files);
        $rules = ['name' => 'string', 'type' => 'string|min:3|max:7'];
        $messages = ['name' => 'Заповніть імя коректно!', 'type' => 'Виберіть тип складу!'];

        Validator::run($post, $rules, $messages);

        if (Validator::status())
            Storage::insert($post);
        else
            echo Validator::errors();
    }

    public function update($post)
    {
        unset($post->data['files']);
        $rules = ['name' => 'string', 'type' => 'string|min:3|max:7'];
        $messages = ['name' => 'Заповніть імя коректно!', 'type' => 'Виберіть тип складу!'];

        Validator::run($post->data, $rules, $messages);

        if (Validator::status())
            Storage::update($post->data, $post->id);
        else
            echo Validator::errors();
    }
}

?>