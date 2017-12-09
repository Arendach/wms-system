<?php

namespace Web\App;

use Web\Middleware\Access;


class Application extends Entity
{
    /**
     * Тимчасові дані
     */
    private $temp;

    /**
     * GET роути
     */
    public $get_routs = [];

    /**
     * POST роути
     */
    public $post_routs = [];

    /**
     * Іменовані роути
     */

    public $named_routs = [];

    /**
     * Перемінні запиту
     */
    private $request_vars;

    /**
     * Всі доступні класи-посередники
     */
    private $middleware = [
        'logout' => \Web\Middleware\Logout::class,
    ];

    /**
     * Класи-посередники за замовчуванням
     */
    private $middleware_rout = [
        \Web\Middleware\Authentication::class,
        \Web\Middleware\UserInit::class,
    ];

    /**
     * Запуск класів посередників
     */
    public function middleware($middleware, $exception)
    {
        // Якщо передано масив з посередниками то ініціалізуємо метод
        // handle() кожного переданого класа посередника
        if (count($middleware) > 0) {
            foreach ($middleware as $item) {
                if (isset($this->middleware[$item]) && class_exists($this->middleware[$item])) {
                    $class = new $this->middleware[$item];
                    if (method_exists($class, 'handle'))
                        $class->handle();
                }
            }
        }

        // Якщо $exception === false, то запускаєм всі класи посередники,
        // якщо $exception === true, то для даного роута посередники за-замовчуванням
        // не будуть застосовані
        if ($exception != true) {
            if (count($this->middleware_rout) > 0) {
                foreach ($this->middleware_rout as $item) {
                    if (class_exists($item)) {
                        $obj = new $item;
                        if (method_exists($obj, 'handle'))
                            $obj->handle();
                    }
                }
            }
        }
    }

    /**
     * Створення роута типу GET
     * Запис параметрів запиту в глобальний масив $this->get_routs
     */
    public function get_named_routs()
    {
        return $this->named_routs;
    }

    /**
     * @param $rout
     * @param $clouser
     * @param array $param
     */
    public function get($rout, $clouser, $param = [])
    {
        if (is_array($clouser)) {
            if (!isset($clouser['uses'])) {
                $message = 'Клас обробник роута не обявлений!';
                $this->display_500($message);
            }

            if (isset($clouser['as']))
                $this->named_routs[$clouser['as']] = $rout;
            $clouser = $clouser['uses'];
        }
        if (preg_match_all("~\{[A-Za-z0-9]+\}~", $rout, $matches)) {
            $c = count($matches[0]);
            $pattern = '';
            for ($i = 1; $i <= $c; $i++) {
                $pattern .= '([A-Za-z0-9]+)/';
            }
        } else {
            $pattern = '';
        }

        $pattern = rtrim($pattern, '/');

        $expression = "~^" . explode("{", $rout)[0] . "{$pattern}$~";
        $this->get_routs[$expression]['clouser'] = $clouser;
        $this->get_routs[$expression]['param'] = $param;
    }

    /**
     * Створення роута типу POST
     * Запис параметрів запиту в глобальний масив $this->post_routs
     */
    public function post($rout, $clouser, $param = [])
    {
        if (is_array($clouser)) {
            if (!isset($clouser['uses'])) {
                $message = 'Клас обробник роута не обявлений!';
                response(500, $message);
            }

            if (isset($clouser['as']))
                $this->named_routs[$clouser['as']] = $rout;
            $clouser = $clouser['uses'];
        }

        $expression = "~^" . $rout . "$~";
        $this->set_post_routs($expression, $clouser, $param);
    }

    /**
     * Run APP
     */
    public function run()
    {
        $request = $_SERVER['REQUEST_URI'];
        $type = $_SERVER['REQUEST_METHOD'];

        $query_str = "";

        if (strpos($request, '?') !== false) {
            $domain = explode('?', $request);
            $request = $domain[0];
            $query_str = $domain[1];
        }

        $this->temp = [
            'type' => $type,
            'request' => $request,
            'query' => $query_str,
            'data' => []
        ];

        if ($type === 'GET') {
            $this->parseGet($request);
        } elseif ($type === 'POST') {
            $data = (object)$_POST;
            $this->temp['data'] = $data;
            $this->parse_post($request, ['data' => $data]);
        }
    }

    /**
     * Парсинг POST запиту
     */
    private function parseGet($request)
    {
        if ($request != '/')
            $request = rtrim($request, '/');

        $this->request_vars = $request;
        $found = false;

        foreach ($this->get_routs as $pattern => $arr) {
            if (preg_match($pattern, $request, $match)) {

                $exception = isset($arr['param']['exception']) && $arr['param']['exception'] == true ? true : false;
                $middleware = isset($arr['param']['middleware']) ? $arr['param']['middleware'] : [];
                $this->middleware($middleware, $exception);

                if (isset($arr['param']['access'])) {
                    $access = new Access();
                    $access->handle($arr['param']['access']);
                }
                array_shift($match);
                $this->call_action($arr['clouser'], $match);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->rout_not_found($request);
        }
    }

    /**
     * Парсинг POST запиту
     */
    private function parse_post($request, $data)
    {
        if ($request != '/')
            $request = rtrim($request, '/');

        foreach ($this->get_post_routs() as $pattern => $action) {
            if (preg_match($pattern, $request)) {

                $exception = isset($action['params']['exception']) && $action['params']['exception'] == true ? true : false;
                if (isset($action['params']['middleware'])) {
                    $this->middleware($action['params']['middleware'], $exception);
                } else {
                    $this->middleware([], $exception);
                }

                if (isset($action['params']['access'])) {
                    $access = new Access();
                    $access->handle($action['params']['access']);
                }
                $this->call_action($action['value'], $data);
                break;
            }
        }
    }

    /**
     * Функція повертає всі POST роути
     */
    public function get_post_routs()
    {
        return $this->post_routs;
    }

    /**
     * Функція записує дані по роутам в глобальний масив post_routs
     */
    private function set_post_routs($key, $value, $params)
    {
        /////////////////////// Якщо вже інує роут то викидуємо виключення /////////////////////////////
        //                                                                                            //
        if (isset($this->post_routs[$key])) {                                                         //
            echo "Помилка! Неможливо переписати існуючий роут :: {$key}";                             //
            exit;                                                                                     //
        }                                                                                             //
        //                                                                                            //
        ////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////// Якщо роута неіснує, то записуємо в глобальний масив ////////////////////
        //                                                                                            //
        else // Записуємо                                                                             //
            $this->post_routs[$key] = ['value' => $value, 'params' => $params];                       //
        //                                                                                            //
        ////////////////////////////////////////////////////////////////////////////////////////////////
    }

    /**
     * Визив метода
     */
    private function call_action($action, $args)
    {

        if (is_string($action)) {
            $this->use_controller($action, $args);
        } elseif (is_callable($action)) {
            global $clouser;
            $clouser->request->setup($this->temp);
            call_user_func_array($action, $args);
        } else {
            $wrong = ['action' => $action, 'data' => $args];
            $this->_log('bad-action', $wrong);
        }
    }

    /**
     * Запуск контроллера
     */
    private function use_controller($str, $args = [])
    {
        $exploded = explode('/', $str);
        $controller = array_shift($exploded);
        $method = array_shift($exploded);

        try {
            $controller = "\\Web\\Controller\\" . $controller;
            $obj = new $controller;
            $obj->request->setup($this->temp);
            call_user_func_array([$obj, $method], $args);
        } catch (Exception $e) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                response(500, $e->getMessage());
            } else {
                $this->display_500($e->getMessage());
            }
        }
    }

    /**
     * Обробник випадку коли роут не знайдений
     */
    private function rout_not_found($route)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            response('404', "Помилка! Роут \"$route\" не знайдений!");
        } else {
            http_status(404);
        }
        exit;
    }
}

?>