<?php

namespace Web\Model;

use Web\Model\Settings\BasicModel as Model;
use RedBeanPHP\R;
class Attributes extends Model
{
    const table = 'defAttributes';

    public static function search($name){
        return R::find(self::table, 'name LIKE :name', ['name' => '%'.$name.'%']);
    }
}