<?php

namespace Web\App;

use \RedBeanPHP\R;

class Paginator
{

    /**
     * @return string
     */
    public static function limit()
    {
        $items = Config::items();
        $start_query = (get('page') - 1) * $items;
        $string = " 
            LIMIT $start_query, $items ";
        return $string;
    }

    /**
     * @param $table
     * @return string
     */
    public static function order($table)
    {
        return " ORDER BY `$table`.`id` DESC";
    }

    /**
     * @param $table
     * @param $parameters
     * @return int
     */
    private function simpleStringCount($table, $parameters)
    {
        return R::count($table, $parameters);
    }

    /**
     * @param $table
     * @param $parameters
     * @return int
     */
    private function simpleArrayCount($table, $parameters)
    {
        $query = '';
        foreach ($parameters as $k) {
            if (!isset($k[2]))
                $k[2] = '=';
            $query .= '`' . $k[0] . '` ' . $k[2] . ' \'' . $k[1] . '\' AND ';
        }
        $query = strlen($query) > 0 ? htmlspecialchars(mb_substr($query, 0, -4)) : '';
        return R::count($table, $query);
    }

    /**
     * @return array
     */
    public function getParametersDefault()
    {
        $get_parameters = '?';
        foreach ($_GET as $k => $v) {
            if (!empty($v) && $k != 'page') {
                $get_parameters .= $k . '=' . $v . '&';
            }
        }
        $url = strlen($get_parameters) > 1 ? htmlspecialchars(mb_substr($get_parameters, 0, -1)) : '?';
        $url_page = $get_parameters == '?' ? '?page=' : $url . '&page=';

        return ['url' => $url, 'url_page' => $url_page];
    }

    /**
     * @param $p
     * @return array
     */
    public function getParametersArray($p)
    {
        $get_parameters = '?';
        foreach ($p as $k => $v) {
            if (!empty($v) && $k != 'page') {
                $get_parameters .= $k . '=' . $v . '&';
            }
        }
        $get_parameters = strlen($get_parameters) > 1 ? htmlspecialchars(mb_substr($get_parameters, 0, -1)) : '';

        $url = $get_parameters;
        $url_page = $get_parameters == '' ? '?page=' : $url . '&page=';

        return ['url' => $url, 'url_page' => $url_page];
    }

    /**
     * @param $table
     * @param bool $parameters
     * @param bool $items
     * @param bool $get
     * @return array
     */
    public static function simple($table, $parameters = false, $items = false, $get = true)
    {
        $items_default = $items === false ? Config::items() : $items;
        $paginator = new Paginator();
        return $paginator->simplePrivate($table, $items_default, $get, $parameters);
    }

    /**
     * @param $table
     * @param $items
     * @param $get
     * @param $parameters
     * @return array
     */
    private function simplePrivate($table, $items, $get, $parameters)
    {
        if (is_array($parameters)) {
            $all = $this->simpleArrayCount($table, $parameters);
        } elseif (is_string($parameters)) {
            $all = $this->simpleStringCount($table, $parameters);
        } else {
            $all = R::count($table);
        }

        if ($get === true) {
            $urls = $this->getParametersDefault();
        } elseif (is_array($get)) {
            $urls = $this->getParametersArray($get);
        } else {
            $urls = ['url' => '?', 'url_page' => '?page='];
        }

        $active = isset($_GET['page']) && is_numeric($_GET['page']) ? abs(intval($_GET['page'])) : 1;

        $item = is_numeric($items) ? $items : Config::get('items');
        $data = [
            'all' => $all,
            'url' => $urls['url'],
            'url_page' => $urls['url_page'],
            'items' => $item,
            'active' => $active

        ];
        return $data;
    }
}