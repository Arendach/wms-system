<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\OrderSettings;

class OrdersSettingsController extends Controller
{
    /**
     * @var array
     */
    private $forms = ['colors', 'regions', 'pays', 'logistics', 'couriers', 'colors'];

    /**
     * @var string
     */
    private $inputs_tpl = '/orders/settings/entities/inputs/';

    /**
     * Перегляд курєрів
     */
    public function index()
    {
        $form = [
            'form' => 'couriers',
            'button' => ['name' => 'Додати курєра'],
            'input' => ['name' => 'name', 'placeholder' => 'Введіть імя']
        ];

        $content = [
            'form' => 'couriers',
            'table' => OrderSettings::getAll('couriers'),
            'inputsTbl' => $this->inputs('universal', $form)
        ];

        $data = [
            'title' => 'Налаштування :: Курєри',
            'section' => 'Курєри',
            'script' => 'orders_settings/orders_settings.js',
            'buttons' => $this->links(),
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'content' => $this->renderTable('/orders/settings/table', $content)
        ];

        $this->view->display('/orders/index', $data);
    }

    /**
     * @param $post
     */
    public function get_form($post)
    {
        $universal_forms = ['pays', 'couriers', 'logistics', 'regions'];

        if (in_array($post->form, $this->forms)) {
            $data = OrderSettings::getOne($post->data['id'], $post->form);
            $data['form'] = $post->form;
        }

        if (isset($data)) {
            if (in_array($post->form, $universal_forms))
                echo $this->view->render('/orders/settings/forms/universal', $data);
            else
                echo $this->view->render('/orders/settings/forms/' . $post->form, $data);
        } else {
            response(400, 'Не правильні вхідні параметри!');
        }
    }

    /**
     * @param $post
     */
    function update($post)
    {
        $data = get_object($post->data);

        if (isset($data->form) && in_array($data->form, $this->forms)) {
            $form = $data->form;
            unset($data->form);
            OrderSettings::update($data, $data->id, $form);
        } else {
            response('400', 'Не правильні вхідні дані!');
        }

    }

    /**
     * @param $post
     */
    public function save($post)
    {
        if (isset($post->form) && in_array($post->form, $this->forms)) {
            $form = $post->form;
            unset($post->form);
            OrderSettings::insert($post, $form);
        } else {
            response(400, 'Не правилні вхідні параметри!');
        }
    }

    /**
     * @param $post
     */
    public function remove($post)
    {
        if (isset($post->data['form']) && in_array($post->data['form'], $this->forms))
            OrderSettings::delete($post->id, $post->data['form']);
        else
            response(400, 'Не правильні вхідні параметри!');
    }

    /**
     * Перегляд регіонів
     */
    public function region_view()
    {
        $form = [
            'form' => 'regions',
            'button' => ['name' => 'Новий регіон'],
            'input' => ['name' => 'name', 'placeholder' => 'Введіть імя']
        ];
        $content = [
            'form' => 'regions',
            'table' => OrderSettings::getAll('regions'),
            'inputsTbl' => $this->inputs('universal', $form)
        ];

        $data = [
            'title' => 'Налаштування :: Регіони',
            'section' => 'Регіони',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'script' => 'orders_settings/orders_settings.js',
            'buttons' => $this->links(),
            'content' => $this->renderTable('/orders/settings/table', $content)
        ];

        $this->view->display('/orders/index', $data);
    }

    /**
     * Перегляд кольорових підказок
     */
    public function color_view()
    {
        $form = [
            'form' => 'colors',
            'button' => ['name' => 'Нова підказка'],
            'color' => ['name' => 'color'],
            'input' => ['name' => 'description', 'placeholder' => 'Введіть опис']
        ];

        $content = [
            'form' => 'colors',
            'table' => OrderSettings::getAll('colors'),
            'inputsTbl' => $this->inputs('color', $form),
        ];

        $data = [
            'title' => 'Налаштування :: Кольорові підказки',
            'section' => 'Кольорові підказки',
            'components' => ['color_picker', 'modal', 'sweet_alert', 'breadcrumbs'],
            'scripts' => ['orders_settings/color_hint.js', 'orders_settings/orders_settings.js'],
            'buttons' => $this->links(),
            'content' => $this->renderTable('/orders/settings/color_table', $content)
        ];

        $this->view->display('/orders/index', $data);
    }

    /**
     * Перегляд способів доставки
     */
    public function logistics_view()
    {
        $form = [
            'form' => 'logistics',
            'button' => ['name' => 'Нова компанія'],
            'input' => ['name' => 'name', 'placeholder' => 'Введіть імя']
        ];

        $content = [
            'table' => OrderSettings::getAll('logistics'),
            'form' => 'logistics',
            'inputsTbl' => $this->inputs('universal', $form)
        ];

        $data = [
            'title' => 'Налаштування :: Способи доставки',
            'section' => 'Способи доставки',
            'form' => 'logistics',
            'buttons' => $this->links(),
            'script' => 'orders_settings/orders_settings.js',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'content' => $this->renderTable('/orders/settings/table', $content)
        ];

        $this->view->display('/orders/index', $data);
    }

    /**
     * Перегляд способів оплати
     */
    public function pay_view()
    {
        $form = [
            'form' => 'pays',
            'button' => ['name' => 'Створити спосіб оплати', 'action' => 'createPay'],
            'input' => ['name' => 'name', 'placeholder' => 'Введіть імя']
        ];

        $content = [
            'form' => 'pays',
            'table' => OrderSettings::getAll('pays'),
            'inputsTbl' => $this->inputs('universal', $form)
        ];

        $data = [
            'title' => 'Налаштування :: Способи оплати',
            'section' => 'Способи оплати',
            'script' => 'orders_settings/orders_settings.js',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'buttons' => $this->links(),
            'content' => $this->renderTable('/orders/settings/table', $content)
        ];

        $this->view->display('/orders/index', $data);
    }

    /**
     * @param $template
     * @param $data
     * @return mixed
     */
    protected function renderTable($template, $data)
    {
        foreach ($data as $key => $value)
            $this->view->{$key} = $value;
        return $this->view->render($template);
    }

    /**
     * @return mixed
     */
    protected function links()
    {
        $links = [
            ['name' => 'Курєри', 'action' => route('couriers')],
            ['name' => 'Доставка', 'action' => route('logistics')],
            ['name' => 'Оплата', 'action' => route('pays')],
            ['name' => 'Кольорові підказки', 'action' => route('colors')],
            ['name' => 'Регіони', 'action' => route('regions')],
        ];

        foreach ($links as &$item)
            if ($this->url() == $item['action']) $item['class'] = 'active';

        $this->view->links = $links;

        return $this->view->render('/orders/settings/links');
    }

    /**
     * @param $type
     * @param $data
     * @return mixed
     */
    protected function inputs($type, $data)
    {
        $tpl = $this->inputs_tpl . $type . '_inputs';
        return $this->view->render($tpl, $data);
    }
}

?>