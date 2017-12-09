<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\App\Log;

class LogController extends Controller
{
    public function write($data)
    {
        Log::parse_ajax_log($data);
    }
}