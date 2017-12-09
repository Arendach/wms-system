<?php

namespace Web\Controller\Orders;

use Web\App\Controller;
use Web\Model\Orders\Update;

class UpdateController extends Controller
{
    /**
     * @var Update
     */
    public $model;

    /**
     * UpdateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new Update();
    }

    /**
     * Точка входу
     * @param $post
     */
    public function handle($post)
    {
        $post = get_object($post);
        if (method_exists($this, $post->form)) {
            $method_name = $post->form;
            $this->$method_name($post->data);
        } else {
            response(400, 'Не правильні вхідні дані!');
        }
    }

    /**
     * Дані по зворотній доставці
     * @param $post
     */
    private function return_shipping($post)
    {
        $this->model->return_shipping($post);
    }

    /**
     * Контактна інформація
     * @param $post
     */
    private function contact($post)
    {
        $this->model->contact($post);
    }

    /**
     * Службова інформація
     * @param $post
     */
    private function working($post)
    {
        $id = $post->id;
        unset($post->id);
        $this->model->working($post, $id);
    }

    /**
     * Зміна статусу
     * @param $post
     */
    private function status($post)
    {
        $this->model->status($post);
    }

    /**
     * @param $post
     */
    private function address($post)
    {
        $id = $post->id;

        unset($post->id);

        $this->model->address($post, $id);
    }

    /**
     * @param $post
     */
    private function pay($post)
    {
        $id = $post->id;

        unset($post->id);

        $this->model->pay($post, $id);
    }

    /**
     * @param $post
     */
    private function products($post)
    {
        $post = get_object($post);

        $order_id = $post->data->id;
        unset($post->data->id);

        $this->model->products($post->products, $post->data, $order_id);
    }
}
