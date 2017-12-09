<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\Index;

class IndexController extends Controller {

	public function index(){
		$data = [
			'title' => 'Адмінка',
			'section' => 'WMS Control Panel',
            'schedules' => Index::work_schedule(),
            'schedules_month' => Index::work_schedules_month(),
            'tools' => 'FormBuilder'
		];

		$this->view->display('/index', $data);
	}
}

?>