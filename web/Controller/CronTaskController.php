<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\Reports\CreateReportIfNotExist as ReportModel;

class CronTaskController extends Controller
{
    /**
     * @var ReportModel
     */
    public $report_model;

    /**
     * CronTaskController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->report_model = new ReportModel();
    }

    /**
     * Обробник контроллера
     */
    public function handle()
    {
        if (method_exists($this, get('task'))) {
            $method_name = get('task');
            $this->$method_name();
        }
    }

    /**
     * Створення нового звіту!!!
     * @TASK
     */
    public function report()
    {
        $this->report_model->createReportFromUsers();
    }

    /**
     * Бекап бази даних
     * @TASK
     */
    public function backup()
    {

    }
}