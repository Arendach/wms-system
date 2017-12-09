<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\App\Validator;
use Web\Model\Manufacturers;
use Web\Model\ManufacturersGroup;

class ManufacturerController extends Controller
{
    /**
     * @GET
     * Виробників на екран
     */
    public function index()
    {
        $data = [
            'title' => 'Каталог :: Виробники',
            'script' => 'manufacturer.js',
            'components' => ['sweet_alert', 'modal', 'summer_note', 'breadcrumbs'],
            'section' => 'Виробники',
            'manufacturers' => Manufacturers::all()
        ];

        $this->view->display('/manufacturer/index', $data);
    }

    /**
     * @POST
     * Форма створення нового виробника
     */
    public function showAdd()
    {
        $data = [
            'title' => 'Додати виробника',
            'groupes' => ManufacturersGroup::getAll()
        ];

        echo $this->view->render('/modal/manufacturer/add', $data);
    }

    /**
     * @POST
     * Пост обробник даних
     */
    public function add($post)
    {
        $rules = [
            'name' => 'string',
            'email' => 'email',
            'address' => 'string|min:1',
        ];

        $messages = [
            'name' => 'Заповніть імя клієнта правильно!',
            'email' => 'Заповніть електронну пошту клієнта правильно!',
            'address' => 'Заповніть адресу клієнта правильно!',
        ];

        Validator::run($post, $rules, $messages);

        unset($post->files);
        if (!Validator::status()) {
            echo Validator::errors();
        } else {
            Manufacturers::insert($post);
        }
    }

    /**
     * @POST
     * Видалити виробника
     */

    public function delete($post)
    {
        if (validator($post->id, 'int') || validator($post->id, 'array'))
            Manufacturers::delete($post->id);
        else
            response(400, 'Неправильні вхідні параметри!');
    }

    /**
     * @POST
     * Форма оновлення інформації про виробника
     */
    public function updateManufacturer($post)
    {
        $data = [
            'manufacturer' => Manufacturers::getOne($post->id),
            'title' => 'Редагування виробників',
            'groups' => ManufacturersGroup::getAll(),
            'id' => $post->id,
        ];

        if (my_count($data['manufacturer']) == 0)
            $this->redirect(route('404'));
        $this->view->display('/modal/manufacturer/update', $data);
    }

    /**
     * @POST
     * Зберегти оновлену інформацію
     */
    public function saveManufacturer($post)
    {
        $id = (int)$post->id;
        unset($post->files);
        unset($post->id);

        $rules = [
            'name' => 'string',
            'email' => 'email',
            'phone' => 'phone',
            'address' => 'string|min:1',
        ];

        $messages = [
            'name' => 'Заповніть імя клієнта правильно!',
            'email' => 'Заповніть електронну пошту клієнта правильно!',
            'phone' => 'Заповніть телефон клієнта правильно!',
            'address' => 'Заповніть адресу клієнта правильно!',
        ];

        Validator::run($post, $rules, $messages);

        if (!Validator::status())
            echo Validator::errors();
        else
            Manufacturers::update($post, $id);
    }

    /**
     * @GET
     * Роздрукувати інформацію по виробниках
     */
    public function printManufacturer($post)
    {
        $data['section'] = 'Виробники';
        $data['table'] = get_object(Manufacturers::printManufacturer($post->ids));
        $this->view->display('/manufacturer/print', $data);
    }
}

?>