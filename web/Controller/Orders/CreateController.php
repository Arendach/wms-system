<?php

namespace Web\Controller\Orders;

use Web\App\Controller;
use Web\Model\Orders\Create;

class CreateController extends Controller
{
    /**
     * @var Create
     */
    private $model;

    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new Create();
    }

    /**
     * @param $post
     */
    public function handle($post)
    {
        $post = get_object($post);

        $arr = ['sending', 'delivery', 'self', 'shop'];

        if (in_array($post->data->type, $arr)) {
            $method_name = $post->data->type;
            $this->$method_name($post);
        } else {
            response(400, 'Не правильні вхідні дані');
        }
    }

    /**
     * @param $post
     */
    private function sending($post)
    {
        if (empty($post->data->fio)) {
            response('400', 'Заповніть імя!');
        }

        if (empty($post->data->phone)) {
            response('400', 'Заповніть телефон!');
        }

        if (empty($post->data->city)) {
            response('400', 'Заповніть місто!');
        }

        if (empty($post->data->warehouse)) {
            response('400', 'Заповніть відділення!');
        }

        if (!isset($post->products))
            response(400, 'Виберіть хоча-б один товар!');

        $temp = $this->return_shipping_parse($post->data);
        $this->model->sending($temp->data, $post->products, $temp->return_shipping);

    }

    /**
     * @param $post
     */
    private function delivery($post)
    {
        if (!isset($post->products))
            response(400, 'Виберіть хоча-б один товар!');
        $this->model->delivery($post->data, $post->products);
    }

    /**
     * @param $post
     */
    private function self($post)
    {
        if (!isset($post->products))
            response(400, 'Виберіть хоча-б один товар!');
        $this->model->self($post->data, $post->products);
    }

    /**
     * @param $post
     */
    private function shop($post)
    {
        if (!isset($post->pay_method) || empty($post->pay_method))
            response('400', 'Виберіть варіант оплати');

        if (!isset($post->products))
            response(400, 'Виберіть хоча-б один товар!');

        $this->model->shop($post->data, $post->products);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function return_shipping_parse($data)
    {
        $temp = new \stdClass();

        foreach ($data as $key => $value) {
            if (preg_match('/return_shipping_/', $key)) {
                $new_key = preg_replace('/return_shipping_([\w]+)/', '$1', $key);
                $temp->$new_key = $value;
                unset($data->$key);
            }
        }

        $result = new \stdClass();

        $result->return_shipping = $temp;
        $result->data = $data;

        return $result;
    }
}