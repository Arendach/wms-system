<?php

namespace Web\App;

class Config
{

    /**
     * @param string $part
     * @return int
     */
    public static function items()
    {
        if (get('items'))
            return get('items');
        else
            return 25;
    }

    /**
     * @param $key
     * @return string
     */
    public static function location($key)
    {
        $arr = [
            'user_not_found' => 'login',
            'access_denied' => 'error/access_denied'
        ];

        if (isset($arr[$key]))
            return SITE . '/' . $arr[$key];
        else
            return SITE . '/';

    }
}