<?php

namespace Web\Model;

use RedBeanPHP\R;
use Web\Model\Settings\BasicModel as Model;

class ClientsGroup extends Model
{
    const table =  'clients_group';

    public static function createGroup($data)
    {
        //Для таблиць з префіксом
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        $c = R::xdispense('clients_group');

        $c->name = $data->name;
        $c->sort = $data->sort;

        $id = R::store($c);
        return $id;
    }

    public static function delete($id, $table = false)
    {
        try{
            R::exec('DELETE FROM `clients_group` WHERE `id` =  ?', [$id]);
            R::exec('UPDATE `clients` SET `group` = 0 WHERE `group` =  ?', [$id]);
            response(200, 'Дані успішно видалені!');
        } catch (\Exception $err){
            $message = 'Помилка при видаленні групи клієнтів!';
            \Web\App\Log::error($err, $message);
            response(500, $message);
        }
    }
}