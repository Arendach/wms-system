<?php

namespace Web\Controller\ControlMoney;

use Web\App\Controller;
use Web\Model\Reports\CreateReportIfNotExist;

class CreateController extends Controller
{
    /**
     * @var CreateReportIfNotExist
     */
    private $model;

    /**
     * CreateController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new CreateReportIfNotExist();
    }

    /**
     * @param $post
     */
    public function handle()
    {
        if (method_exists($this, get('type'))) {
            $method_name = get('type');
            $this->$method_name();
        } else {
            $this->profits();
        }
    }

    /**
     * Прибуток
     */
    public function profits()
    {
        $data = [
            'title' => '',
            'js' => ['control_money/create']
        ];

        $this->view->display('/control_money/create/profits', $data);
    }

    /**
     * Витрати на доставку
     */
    public function shipping_costs()
    {
        $data = [
            'title' => '',
            'js' => ['control_money/create']
        ];

        $this->view->display('/control_money/create/profits', $data);
    }

    /**
     * Переміщення коштів
     */
    public function moving()
    {
        $data = [
            'title' => '',
            'js' => ['control_money/create']
        ];

        $this->view->display('/control_money/create/profits', $data);
    }

    /**
     * Видатки
     */
    public function expenditures()
    {
        $data = [
            'title' => '',
            'js' => ['control_money/create']
        ];

        $this->view->display('/control_money/create/profits', $data);
    }


}