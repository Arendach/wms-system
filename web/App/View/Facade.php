<?php

namespace Web\App\View;

use Web\App\View\Template;

class Facade
{
    public static function run($content)
    {
        $object = new Template();
        return $object->run($content);
    }
}