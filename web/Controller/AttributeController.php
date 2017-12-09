<?php
namespace Web\Controller;

use Web\Model\Attributes;
use Web\App\Controller;

class AttributeController extends Controller
{
    /**
     * @GET
     */
    public function index()
    {
        $data = [
            'title' => 'Налаштування :: Атрибути',
            'section' => 'Атрибути',
            'script' => 'attribute.js',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'attributes' => Attributes::getAll()
        ];

        $this->view->display('/attributes/index', $data);
    }

    /**
     * @param $post
     */
    public function get_form($post)
    {
        if($post->form == 'update')
            $this->form_update(get_object($post->data));
        elseif ($post->form = 'create')
            $this->form_create();
    }

    /**
     * @param $post
     */
    public function form_update($post)
    {
        $data = [
            'title' => 'Редагувати аттрибут',
            'attribute' => Attributes::getOne($post->id),
        ];

        echo $this->view->render('/modal/attributes/update', $data);
    }

    /**
     * @GET
     */
    public function form_create()
    {
        $data = [
            'title' => 'Налаштування :: Створити атрибут',
            'section' => 'Створити атрибут',
            'attr' => Attributes::getAll()
        ];

        $this->view->display('/modal/attributes/add', $data);
    }

    /**
     * @param $post
     */
    public function create($post)
    {
        Attributes::insert($post);
    }

    /**
     * @param $post
     */
    public function update($post)
    {
        Attributes::update($post->data, $post->id);
    }

    /**
     * @param $data
     */
    public function delete($data)
    {
        Attributes::delete($data->id);
    }
}

?>