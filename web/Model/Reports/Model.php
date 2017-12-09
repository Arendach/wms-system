<?php

namespace Web\Model;

use Web\Model\Reports\CreateReportIfNotExist;
use Web\Model\Settings\BasicModel;

class Model extends BasicModel
{
    const table = 'reports';
    use CreateReportIfNotExist;
}