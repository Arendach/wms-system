<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\ControlMoney;
use Web\Model\User;

class ControlMoneyController extends Controller
{
    /**
     * @GET
     */
    public function index()
    {
        if (get('year')) {
            if (get('month')) {
                if (get('user')) {
                    $this->user();
                } else {
                    $this->users();
                }
            } else {
                $this->months();
            }
        } else {
            $this->years();
        }
    }

    /**
     * Display years
     */
    public function years()
    {
        $data = [
            'title' => 'Менеджери :: Контроль витрат',
            'components' => ['breadcrumbs'],
            'include' => 'years'
        ];

        $this->view->display('/control_money/index', $data);
    }

    /**
     * Display months
     */
    public function months()
    {
        $data = [
            'title' => 'Менеджери :: Контроль витрат',
            'components' => ['breadcrumbs'],
            'include' => 'months'
        ];

        $this->view->display('/control_money/index', $data);
    }

    /**
     * Display users
     */
    public function users()
    {
        $data = [
            'title' => 'Менеджери :: Контроль витрат',
            'components' => ['breadcrumbs'],
            'include' => 'users',
            'users' => User::getAll()
        ];

        $this->view->display('/control_money/index', $data);
    }

    /**
     * Display user schedule
     */
    public function user()
    {
        $head = ControlMoney::getHead();

        $spending = json_decode($head->spending);
        $profits = json_decode($head->profits);

        $body = ControlMoney::getBody($head->id);

        $data = [
            'title' => 'Менеджери :: Контроль витрат',
            'components' => ['breadcrumbs', 'sweet_alert', 'modal'],
            'include' => 'user',
            'head' => $head,
            'spending_fields' => $spending,
            'profits_fields' => $profits,
            'body' => $body,
            'scripts' => ['control_money/main.js'],
            'to_js' => [
                'id' => $head->id
            ]
        ];

        $this->view->display('/control_money/index', $data);
    }

    /**
     * Get Form handler
     * @param $post
     */
    public function get_form($post)
    {
        if ($post->form == 'update') {
            $this->update_form($post->data);
        } elseif ($post->form == 'create') {
            $this->create_form($post->data);
        }
    }

    /**
     * @param $post
     */
    public function update_form($post)
    {
        $control_money = ControlMoney::getFields($post['id']);
        $control_money_item = ControlMoney::getItem($post['id']);

        $item_profit = json_decode($control_money_item->profits);
        $item_spending = json_decode($control_money_item->spending);

        $profits = [];
        foreach (json_decode($control_money['profits']) as $k => $value)
            $profits[$value] = $item_profit[$k];

        $spending = [];
        foreach (json_decode($control_money['spending']) as $k => $value)
            $spending[$value] = $item_spending[$k];

        $data = [
            'profits' => $profits,
            'spending' => $spending
        ];

        $this->view->display('/control_money/forms/update', $data);
    }

    /**
     * @param $post
     */
    public function create_form($post)
    {
        $control_money = ControlMoney::getFields($post['id']);

        $this->view->display('/control_money/forms/create', $control_money);
    }
}