<?php

namespace Web\Model\Settings;

use Couchbase\Exception;
use RedBeanPHP\R;
use Web\App\Log;

class BasicModel
{
    const table = 'parent';
    const parent = 'parent';

    /**
     * @param $id
     * @param bool $table
     * @return \RedBeanPHP\OODBBean
     */
    public static function getOne($id, $table = false)
    {
        if (!$table)
            $table = static::table;

        return R::load($table, $id);
    }

    /**
     * @param bool $table
     * @return array
     */
    public static function getAll($table = false)
    {
        if (!$table)
            $table = static::table;

        return R::findAll($table);
    }

    /**
     * @param $data
     * @param $id
     * @param bool $table
     */
    public static function update($data, $id, $table = false)
    {
        try {
            if ($table === false)
                $table = static::table;
            $bean = R::load($table, $id);
            foreach ($data as $k => $v)
                $bean->$k = to_bd($v);
            R::store($bean);
            response(200, 'Дані успішно оновлені!');
        } catch (\Exception $err) {
            Log::error($err, 'update_error');
            response(500, 'Неможливо оновити елемент!');
        }
    }

    /**
     * @param $parameters
     * @param bool $table
     */
    public static function delete($parameters, $table = false)
    {
        try {
            if (!$table)
                $table = static::table;

            if (validator($parameters, 'array')) {
                foreach ($parameters as $id)
                    R::exec("DELETE FROM " . $table . " WHERE `id` = ?", [$id]);
            } elseif (validator($parameters, 'int')) {
                R::exec("DELETE FROM " . $table . " WHERE `id` = ?", [$parameters]);
            } else {
                response(400, 'Неправильні вхідні параметри!');
                exit;
            }
            response(200, 'Дані успішно видалено!');
        } catch (\Exception $err) {
            Log::error('table: ' . $table . ', id or ids: ' . json_encode($parameters), 'delete_error');
            response(500, 'Помилка! Дані не видалено!');
        }
    }

    /**
     * @param $parameters
     * @param bool $table
     * @param bool $parent
     */
    public static function delete_parent($parameters, $table = false, $parent = false)
    {
        try {
            if (!$parent)
                $parent = self::parent;

            if (!$table)
                $table = static::table;

            if (validator($parameters, 'array')) {
                foreach ($parameters as $id) {
                    R::exec("DELETE FROM `$table` WHERE `id` = ?", [$id]);
                    R::exec("DELETE FROM `$table` WHERE `$parent` = ?", [$id]);
                }
            } elseif (validator($parameters, 'int')) {
                R::exec("DELETE FROM `$table` WHERE `id` = ?", [$parameters]);
                R::exec("DELETE FROM `$table` WHERE `$parent` = ? ", [$parameters]);
            } else {
                response(400, 'Неправильні вхідні параметри!');
                exit;
            }
            response(200, 'Всі дані збережено!');
        } catch (Exception $err) {
            Log::error('Помилка! Неможливо видалити елемент!', 'delete_error');
            response(500, 'Невідома помилка!');
        }
    }

    /**
     * @param $data
     * @param bool $table
     */
    public static function insert($data, $table = false)
    {
        // Для таблиць з префіксом
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        if (!$table)
            $table = static::table;

        $bean = R::xdispense($table);
        foreach ($data as $k => $v)
            $bean->$k = to_bd($v);

        $id = R::store($bean);

        return res(['status' => '1', 'id' => $id]);
    }

    /**
     * @param $table
     * @param string $sql
     * @param array $binds
     * @return int
     */
    public static function count($table, $sql = '', $binds = [])
    {
        return R::count($table, $sql, $binds);
    }
}

?>