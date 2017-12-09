<?php

namespace Web\App;

class Validator
{
    /**
     * Масив помилок
     */

    private static $errors = [];

    /**
     * Масив правил
     */

    private static $rules = [
        'integer',
        'string',
        'float',
        'min',
        'max',
        'text',
        'email',
        'phone',
        'not_null',
        'boolean'
    ];

    /**
     * Запуск валідатора
     */

    public static function run($data, $r = [], $messages = [])
    {
        $prefix = 'validate_';
        foreach ($data as $k => $v) {
            if (isset($r[$k])) {
                $rules = explode('|', $r[$k]);
                foreach ($rules as $rule) {
                    $mess = isset($messages[$k]) ? $messages[$k] : '';
                    if (preg_match('/^([a-z]+)(\:)([0-9]+)$/', $rule, $matches)) {
                        $method_name = $prefix . $matches['1'];
                        static::$method_name($v, $matches[3], $mess, $k);

                    } elseif (in_array($rule, static::$rules)) {
                        $method_name = $prefix . $rule;
                        static::$method_name($v, $mess, $k);
                    }
                }
            }
        }
    }

    /**
     * Валідація строки
     */

    public static function validate_string($string, $message, $key)
    {
        if (!is_string($string))
            static::$errors[$key] = $message;
        elseif (strlen($string) > 1024)
            static::$errors[$key] = $message;
        elseif (strlen($string) < 1)
            static::$errors[$key] = $message;
    }

    /**
     * Валідація null
     */

    public static function validate_not_null($string, $message, $key)
    {
        if ($string === null)
            static::$errors[$key] = $message;
        elseif ($string === 0)
            static::$errors[$key] = $message;
        elseif ($string === 'null')
            static::$errors[$key] = $message;
        elseif ($string === '0')
            static::$errors[$key] = $message;
        elseif ($string == '')
            static::$errors[$key] = $message;
    }

    /**
     * Валідація строки
     */

    public static function validate_phone($string, $message, $key)
    {
        if (!preg_match('/^[\+]{0,1}[0-9]{0,2}[0-9]{10}$/', $string))
            static::$errors[$key] = $message;
    }

    /**
     * Валідація email
     */

    public static function validate_email($string, $message, $key)
    {
        if (!preg_match('/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/', $string))
            static::$errors[$key] = $message;
    }

    /**
     * Валідація числа типу integer
     */

    public static function validate_integer($string, $message, $key)
    {
        if (!preg_match('/^[0-9]+$/', $string))
            static::$errors[$key] = $message;
        /* elseif (strlen($string) > 11)
             static::self::$errors[$key] = $message;
         dd(static::$errors);*/
    }

    /**
     * Валідація числа типу float
     */

    public static function validate_float($string, $message, $key)
    {
        if (!preg_match('/^([0-9]+)([\.]{0,1})([0-9]{0,2})$/', $string))
            static::$errors[$key] = $message;
    }

    /**
     * Валідація максимального значення
     */

    public static function validate_max($string, $int, $message, $key)
    {
        if (strlen($string) > $int)
            static::$errors[$key] = $message;
    }

    /**
     * Валідація мінімального значення
     */

    public static function validate_min($string, $int, $message, $key)
    {
        if (strlen($string) < $int)
            static::$errors[$key] = $message;
    }

    /**
     * Валідація текст
     */

    public static function validate_text($string, $message, $key)
    {
        if (strlen($string) < 1)
            static::$errors[$key] = $message;
    }

    /**
     * Првірка на наявність помилок валідації
     */

    public static function status()
    {
        if (my_count(static::$errors) > 0)
            return false;
        else
            return true;
    }

    /**
     * Вивід на екран помилок
     */

    public static function errors()
    {
        $errors = '';
        foreach (static::$errors as $item) {
            $errors .= '<li class="text-danger">' . $item . '</li><br>';
        }

        return '<div class="alert alert-error">' . $errors . '</div>';
    }
}