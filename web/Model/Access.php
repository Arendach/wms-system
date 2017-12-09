<?php

namespace Web\Model;

use Couchbase\Exception;
use Web\Model\Settings\BasicModel as Model;
use RedBeanPHP\R;

class Access extends Model
{
    const table = 'users_access';

    public static function get_access($id)
    {
        $access_group = R::load('users_access', $id);
        $access = json_decode($access_group['params']);
        $access_all = R::getAll('SELECT * FROM `users_access_all`');
        $access = !empty($access) ? $access : [];

        foreach ($access_all as $id => $item) {
            if (in_array($item['access'], $access)) {
                $access_all[$id]['checked'] = 1;
            } else {
                $access_all[$id]['checked'] = 0;
            }
        }

        $i = 0;
        foreach ($access_all as $item) {
            $access_new[$item['part']][$i]['access'] = $item['access'];
            $access_new[$item['part']][$i]['name'] = $item['name'];
            $access_new[$item['part']][$i]['checked'] = $item['checked'];
            $access_new[$item['part']][$i]['description'] = $item['description'];
            $access_new[$item['part']][$i]['id'] = $item['id'];
            $i++;
        }


        return $access_new;
    }

    public static function update_group($data, $id)
    {
        try {
            $bean = R::load('users_access', $id);
            $bean->params = json_encode($data);
            R::store($bean);
            response(200, 'Виконано! Дані вдало оновлено!');
        } catch (Exception $err) {
            \Web\App\Log::error($err, 'update_access_error');
            response(500, 'Помилка! Дані не оновлено!');
        }
    }

    public static function get_all()
    {
        $items = R::findAll('users_access_all');

        $i = 0;
        foreach ($items as $item) {
            $access_new[$item['part']][$i]['access'] = $item['access'];
            $access_new[$item['part']][$i]['description'] = $item['description'];
            $access_new[$item['part']][$i]['name'] = $item['name'];
            $access_new[$item['part']][$i]['id'] = $item['id'];
            $i++;
        }

        return $access_new;
    }

    public static function access_group_create($post)
    {
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        try {
            $bean = R::xdispense('users_access');
            $bean->name = $post->name;
            $bean->description = $post->description;
            $bean->params = json_encode($post->values);
            R::store($bean);
            response(200, 'Всі дані збережено!');
        } catch (Exception $err) {
            \Web\App\Log::error($err, 'create_access_error');
            response(500, 'При створенні групи сталась помилка!');
        }
    }

    public static function get_all_groups()
    {
        return R::getAll('SELECT `id`, `name`, `description` FROM `users_access`');
    }

    public static function group_delete($data)
    {
        try{
            R::exec('
                UPDATE `users` SET `access` = 0 WHERE `access` = :access; 
                DELETE FROM `users_access` WHERE `id` = :access',
                [':access' => $data->id]);
            response(200, 'Дані успішно видалено!');
        } catch (Exception $err) {
            \Web\App\Log::error($err, 'error_delete_access_group');
            response(500, 'Помилка!');
        }
    }
}