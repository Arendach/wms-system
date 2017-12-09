<?php

/**
 * @param $id
 * @param string $default
 * @return string
 */
function template_class($id, $default = 'default')
{
    return isset($_COOKIE[$id . '_template_class']) ? $_COOKIE[$id . '_template_class'] : $default;
}

/**
 * @param $array
 * @return bool|object
 */
function get_object($array)
{
    if (!is_array($array) && !is_object($array)) {
        return false;
    } else {
        $result = (object)[];
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $result->$k = get_object($v);
            } else {
                $result->$k = $v;
            }
        }
        return $result;
    }
}

/**
 * @param $object
 * @return array|bool
 */
function get_array($object)
{
    if (!is_object($object) && !is_array($object)) {
        return false;
    } else {
        $result = [];
        foreach ($object as $k => $v) {
            if (is_array($v)) {
                $result[$k] = get_array($v);
            } else {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}

/**
 * @param $param
 * @return int
 */
function my_count($param)
{
    if (is_object($param)) {
        $tmp = (array)$param;
        $result = count($tmp);
    } elseif (is_array($param)) {
        $result = count($param);
    } else {
        $result = 0;
    }

    return (int)$result;
}

/**
 * @param string $key
 * @param bool $assoc
 * @return array|bool|float|int|object|string
 */
function get($key = 'get_all_in_object', $assoc = false)
{
    if ($key == 'get_all_in_object') {
        if ($assoc === true) {
            $i = 0;
            $params = [];
            foreach ($_GET as $k => $v) {
                $params[$i][$k] = $v;
                $i++;
            }
            return $params;
        } else {
            return get_object($_GET);
        }
    } elseif ($key == 'page') {
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            return abs(intval($_GET['page']));
        } else
            return 1;
    } else {
        if (isset($_GET[$key]))
            return (string)htmlspecialchars($_GET[$key]);
        else
            return false;
    }
}

/**
 * @param $var
 */
function dd($var)
{
    echo '<pre style="z-index: 9999999;">';
    print_r($var);
    echo '</pre>';
    exit;
}

/**
 * @param $var
 */
function res($var)
{
    echo json_encode($var);
}

/**
 * @param $s
 * @param bool $message
 */
function status($s, $message = false)
{

    if (!is_string($message)) {
        if ($s == 1) {
            response(200);
        } else {
            response(400);
        }
    } else {
        if ($s == 1) {
            response(200, $message);
        } else {
            response(400, $message);
        }
    }
}

/**
 * @param $str
 * @return string
 */
function to_bd($str)
{
    return htmlspecialchars($str);
}

/**
 * @param $var
 * @return bool
 */
function val($var)
{
    if ($var == '0')
        return false;
    elseif ($var === false)
        return false;
    elseif ($var === 0)
        return false;
    elseif ($var == 'null')
        return false;
    elseif ($var === null)
        return false;
    elseif ($var == '')
        return false;
    else
        return $var;
}

/**
 * Очищення папки від файлів
 * @param $dir
 */
function dir_clean($dir)
{
    dir_delete($dir);
    mkdir($dir);
}

/**
 * Видалення папки з файлами
 * @param $dir
 */
function dir_delete($dir)
{
    if (!is_dir($dir)) {
        mkdir($dir);
    }
    if (substr($dir, strlen($dir) - 1, 1) != '/') {
        $dir .= '/';
    }
    $files = glob($dir . '*', GLOB_MARK);
    foreach ($files as $file) {
        is_dir($file) ? dir_delete($file) : unlink($file);
    }
    rmdir($dir);
}

/**
 * Валідацтор, провіряє перемінну на пустоту, число, строку, масив
 * @param $value
 * @param string $rule
 * @return bool
 */
function validator($value, $rule = 'required')
{
    switch ($rule) {
        case 'required':
            return $value == '' ? false : true;
            break;
        case 'int':
            return !is_numeric($value) ? false : true;
            break;
        case 'string':
            return !is_string($value) ? false : true;
            break;
        case 'array':
            if (my_count($value) == 0)
                return false;
            else
                return true;
            break;
        default:
            return false;
            break;
    }
}

/**
 * @param $url
 * @return string
 */
function tpl($url)
{
    return tpl . $url;
}

/**
 * @param $file
 * @return string
 */
function t_file($file)
{
    return __DIR__ . tpl . '/' . $file . '.tpl';
}

/**
 * @param $file
 * @return string
 */
function pages($file)
{
    return FOLDER . '/web/template/default/pages/' . $file . '.tpl';
}

/**
 * @param $file
 * @return string
 */
function style($file)
{
    return '<link rel="stylesheet" href="' . SITE . TEMPLATE_FOLDER . 'css/' . $file . '.css">';
}

/**
 * @param $path
 * @return string
 */
function script($path)
{
    return '<script src="' . tpl($path) . '"></script>';
}

/**
 * @param $name
 * @return string
 */
function get_order($name)
{
    $default = 'desc';
    if (get('order_field') == $name)
        return get('order') == 'asc' ? 'desc' : 'asc';
    else
        return $default;
}

/**
 * @param $name
 * @return string
 */
function get_sym($name)
{
    if (get('order_field') == $name)
        return get('order') == 'asc' ? '&#9650;' : '&#9660;';
    else
        return '';
}

/**
 * @param $id - Статус
 * @param $type - Тип замовлення
 * @return string - <span style="color: #000">Description</span>
 */
function get_order_status($id, $type)
{
    $id = $id == 'default' ? '0' : $id;
    $status = \Web\Model\OrderSettings::statuses($type);

    if (!isset($status[$id])) return '';

    return '<span style="color: ' . $status[$id]->color . ';">' . $status[$id]->text . '</span>';
}

/**
 * @param $type - Тип замовлення
 * @param null $sel - Вибраний статус
 * @return string - <option value="1">Description</option>.....
 */
function get_order_statuses($type, $sel = null)
{
    $str = '';
    foreach (\Web\Model\OrderSettings::statuses($type) as $k => $status) {
        $selected = $k == $sel ? 'selected' : '';
        $str .= '<option ' . $selected . ' value="' . $k . '">' . $status->text . '</option>';
    }
    return $str;
}

/**
 * @param $int - 1-12
 * @return string - назва місяця на укрїнській
 */
function int_to_month($int)
{
    if ($int == '1' || $int == '01') {
        return 'Січень';
    } elseif ($int == '2' || $int == '02') {
        return 'Лютий';
    } elseif ($int == '3' || $int == '03') {
        return 'Березень';
    } elseif ($int == '4' || $int == '04') {
        return 'Квітень';
    } elseif ($int == '5' || $int == '05') {
        return 'Травень';
    } elseif ($int == '6' || $int == '06') {
        return 'Червень';
    } elseif ($int == '7' || $int == '07') {
        return 'Липень';
    } elseif ($int == '8' || $int == '08') {
        return 'Серпень';
    } elseif ($int == '9' || $int == '09') {
        return 'Вересень';
    } elseif ($int == '10') {
        return 'Жовтень';
    } elseif ($int == '11') {
        return 'Листопад';
    } elseif ($int == '12') {
        return 'Грудень';
    } else {
        return '';
    }
}

/**
 * @param $date - Y-m-d
 * @return null|string  - День тижня на українській
 */
function date_to_day($date)
{
    $day = date('D', strtotime($date));
    if ($day == 'Fri') {
        return 'Пятниця';
    } elseif ($day == 'Sat') {
        return 'Субота';
    } elseif ($day == 'Sun') {
        return 'Неділя';
    } elseif ($day == 'Mon') {
        return 'Понеділок';
    } elseif ($day == 'Tue') {
        return 'Вівторок';
    } elseif ($day == 'Wed') {
        return 'Середа';
    } elseif ($day == 'Thu') {
        return 'Четвер';
    }
    return null;
}

/**
 * @param $file
 * @return string
 */
function parts($file)
{
    return __DIR__ . '/web/template/default/parts/' . $file . '.tpl';
}

/**
 * @param $arr - асоціативний масив виду [key => value]
 * @return mixed - строка виду <script> var key = 'value'; </script>
 */
function to_javascript($arr)
{
    $core = '<script>%s</script>';
    $obj = '';
    foreach ($arr as $key => $item)
        $obj .= "var $key = " . json_encode($item) . ';';
    return str_replace('%s', $obj, $core);
}

/**
 * @param $status - Код статуса http
 */
function http_status($status)
{
    $statuses = [
        /**
         * 1xx: Informational (информационные)
         */
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',

        /**
         * 2xx: Success (успешно)
         */
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted', // принято
        203 => 'Non-Authoritative Information', // информация не авторитетна
        204 => 'No Content', // нет содержимого
        205 => 'Reset Content', // сбросить содержимое
        206 => 'Partial Content', // частичное содержимое
        207 => 'Multi-Status', // многостатусный
        208 => 'Already Reported', // уже сообщалось
        226 => 'IM Used', // использовано IM

        /**
         * 3xx: Redirection (перенаправление)
         */
        300 => 'Multiple Choices', // множество выборов
        301 => 'Moved Permanently', // перемещено навсегда
        302 => 'Moved Temporarily', // перемещено временно
        303 => 'See Other', // смотреть другое
        304 => 'Not Modified', // не изменялось
        305 => 'Use Proxy', // использовать прокси
        306 => '', // зарезервировано (код использовался только в ранних спецификациях)[7];
        307 => 'Temporary Redirect', //' временное перенаправление
        308 => 'Permanent Redirect', // постоянное перенаправление.

        /**
         * 4xx: Client Error (ошибка клиента)
         */
        400 => 'Bad Request', // плохой, неверный запрос
        401 => 'Unauthorized', // не авторизован
        402 => 'Payment Required', // необходима оплата
        403 => 'Forbidden', // запрещено
        404 => 'Not Found', // не найдено
        405 => 'Method Not Allowed', // метод не поддерживается
        406 => 'Not Acceptable', // неприемлемо
        407 => 'Proxy Authentication Required', // необходима аутентификация прокси
        408 => 'Request Timeout', // истекло время ожидания
        409 => 'Conflict', // конфликт
        410 => 'Gone', // удалён
        411 => 'Length Required', // необходима длина
        412 => 'Precondition Failed', // условие ложно
        413 => 'Payload Too Large', // полезная нагрузка слишком велика
        414 => 'URI Too Long', // URI слишком длинный
        415 => 'Unsupported Media Type', // неподдерживаемый тип данных
        416 => 'Range Not Satisfiable', // диапазон не достижим
        417 => 'Expectation Failed', // ожидание не удалось
        418 => 'I’m a teapot', // я — чайник
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity', // необрабатываемый экземпляр
        423 => 'Locked', // заблокировано
        424 => 'Failed Dependency', // невыполненная зависимость
        426 => 'Upgrade Required', // необходимо обновление
        428 => 'Precondition Required', // необходимо предусловие
        429 => 'Too Many Requests', // слишком много запросов
        431 => 'Request Header Fields Too Large', // поля заголовка запроса слишком большие
        444 => '', //Закрывает соединение без передачи заголовка ответа. Нестандартный код
        449 => 'Retry With', //' повторить с
        451 => 'Unavailable For Legal Reasons', // недоступно по юридическим причинам

        /**
         * 5xx: Server Error (ошибка сервера)
         */
        500 => 'Internal Server Error', // внутренняя ошибка сервера
        501 => 'Not Implemented', // не реализовано
        502 => 'Bad Gateway', // плохой, ошибочный шлюз
        503 => 'Service Unavailable', // сервис недоступен
        504 => 'Gateway Timeout', // шлюз не отвечает
        505 => 'HTTP Version Not Supported', // версия HTTP не поддерживается
        506 => 'Variant Also Negotiates', // вариант тоже проводит согласование
        507 => 'Insufficient Storage', // переполнение хранилища
        508 => 'Loop Detected', // обнаружено бесконечное перенаправление
        509 => 'Bandwidth Limit Exceeded', // исчерпана пропускная ширина канала
        510 => 'Not Extended', // не расширено
        511 => 'Network Authentication Required', // требуется сетевая аутентификация
        520 => 'Unknown Error', // неизвестная ошибка
        521 => 'Web Server Is Down', // веб-сервер не работает
        522 => 'Connection Timed Out', // соединение не отвечает
        523 => 'Origin Is Unreachable', // источник недоступен
        524 => 'A Timeout Occurred', // время ожидания истекло
        525 => 'SSL Handshake Failed', // квитирование SSL не удалось
        526 => 'Invalid SSL Certificate', // недействительный сертификат SSL
    ];
    if (isset($statuses[$status]))
        header('HTTP/1.1 ' . $status . ' ' . $statuses[$status]);
}

/**
 * @param $status - http код відповіді сервера
 * @param bool $messageOrArray - Повідомлення або масив,
 * який буде передано клієнту в виді JSON - строки
 */
function response($status, $messageOrArray = false)
{
    http_status($status);
    if (is_array($messageOrArray))
        echo json_encode($messageOrArray);
    elseif (is_string($messageOrArray))
        echo json_encode(['message' => $messageOrArray]);
    exit;
}

/**
 * @param $url - Адреса на яку робиться переадресація
 */
function redirect($url)
{
    header('Location: ' . $url);
}

/**
 * @return string - Повна адреса сайту, http://site.com
 */
function my_site_url()
{
    return FOLDER == '' ? SITE : SITE . '/' . FOLDER;
}

/**
 * @param $rout_key - назва роута
 * @param bool $data - асоціативний масив значень [id => 123]
 * @return string    - http://site.com/route/123
 */
function route($rout_key, $data = false)
{
    global $app;
    $routs = $app->get_named_routs();
    if (!isset($routs[$rout_key])) {
        $message = 'Роута "' . $rout_key . '" не існує!';
        \Web\App\Log::error($message, 'route_not_found');
        return '#route_not_found';
    }

    $rout = $routs[$rout_key];
    preg_match_all('/{([A-z0-9]+)}/', $rout, $matches);
    if (my_count($matches) > 0) {
        foreach ($matches[1] as $item) {
            $pattern = "/\{$item\}/";
            $rout = preg_replace($pattern, $data[$item], $rout);
        }
    }
    return my_site_url() . $rout;
}

/**
 * @param $type
 * @return string - Тип замовлення на українській
 */
function type_parse($type)
{
    switch ($type) {
        case 'delivery':
            return 'Доставка';
            break;
        case 'shop':
            return 'Магазин';
            break;
        case 'self':
            return 'Самовивіз';
            break;
        case 'sending':
            return 'Відправка';
            break;
        default:
            return '';
            break;
    }
}

/**
 * @param array $parameters - Масив виду [key => value,....]
 * @return bool|string - строка виду ?key=value...
 */
function parameters(array $parameters)
{
    $string = '?';
    foreach ($parameters as $key => $value)
        $string .= $key . '=' . $value . '&';
    return substr($string, 0, strlen($string) - 1);
}

/**
 * @param string $key - Перевірка користувача на відсутність ключа доступу
 * @return bool - false - якщо ключ існує, true - якщо не існує
 */
function cannot($key = 'ROOT')
{
    $my_access = user()->access;

    if ($my_access === true) {
        return false;
    } elseif ($my_access === false) {
        return true;
    } elseif (my_count($my_access) > 0) {
        $my_access = get_array($my_access);
        if (!in_array($key, $my_access)) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

/**
 * @param string $key - Перевірка користувача на наявніть ключа доступу
 * @return bool - true - якщо ключ існує, false - якщо не існує
 */
function can($key = 'ROOT')
{
    $my_access = user()->access;
    if ($my_access === true) {
        return true;
    } elseif ($my_access === false) {
        return false;
    } elseif (my_count($my_access) > 0) {
        $my_access = get_array(user()->access);
        if (!in_array($key, $my_access)) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

/**
 * @param $string
 * @return string
 */
function my_hash($string)
{
    return trim(\Web\App\Security::p_hash($string));
}

/**
 * @param int $month
 * @param int $year
 * @return int|mixed
 */
function day_in_month($month = 1, $year = 2017)
{
    $array = [
        1 => 31,
        2 => type_year($year),
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31
    ];
    if (isset($array[$month]))
        return $array[$month];
    else
        return 30;
}

/**
 * @param $year
 * @return int
 */
function type_year($year)
{
    $start = 2016;

    $high = [];
    for ($i = $start; $i < 2056; $i = $i + 4) {
        $high[] = $i;
    }

    if (in_array($year, $high)) {
        return 29;
    } else {
        return 28;
    }
}

/**
 * @param int $id
 * @return bool|object|\RedBeanPHP\OODBBean
 */
function user($id = 0)
{
    if ($id == 0)
        return get_object($GLOBALS['user_info_init']);
    else
        return \Web\Model\User::getOne($id);
}

/**
 * Підключення javascript файлу
 * @param $name
 * @return string
 */
function script_file($name)
{
    return '<script src="' . SITE . FOLDER . TEMPLATE_FOLDER . 'js/' . $name . '.js"></script>';
}

/**
 * @param $string
 * @return bool
 */
function is_json($string)
{
    if (!is_string($string)) return false;

    return preg_match('/\{(?:[^{}]|(?R))*\}/', $string) ? true : false;
}

/**
 * @param $string
 * @return bool
 */
function is_json_array($string)
{
    if (!is_string($string)) return false;

    return preg_match('/\[(\"[\w]+\",?){0,}\]/', $string) ? true : false;
}

/**
 * @param $str
 * @return string
 */
function string_to_time($str)
{
    if (preg_match('/[0-9]{1,2}:[0-9]{1,2}/', $str)) $str = time_to_string($str);

    if (mb_strlen($str) == 4)
        return $str[0] . $str[1] . ':' . $str[2] . $str[3];
    elseif (mb_strlen($str) == 3)
        return $str[0] . $str[1] . ':' . $str[2] . '0';
    elseif (mb_strlen($str) == 2)
        return $str[0] . $str[1] . ':' . '00';
    else
        return '0' . $str[0] . ':00';
}

/**
 * @param $time
 * @return string
 */
function time_to_string($time)
{
    if (mb_strlen($time) > 5) $time = substr($time, 0, 5);

    if (preg_match('/^([0-9]{1,2}):([0-9]{1,2})$/', $time, $matches)) {
        return $matches[1] . $matches[2];
    } elseif (preg_match('/^[0-9]{1,4}$/', $time, $matches)) {
        return time_to_string(string_to_time($matches[0]));
    } else {
        return '0000';
    }
}

/**
 * Возвращает сумму прописью
 * @author runcore
 * @uses morph(...)
 */
function num2str($num)
{
    $nul = 'нуль';
    $ten = array(
        array('', 'один', 'два', 'три', 'чотири', 'пять', 'шість', 'сім', 'вісім', 'девять'),
        array('', 'одна', 'дві', 'три', 'чотири', 'пять', 'шість', 'сім', 'вісім', 'девять'),
    );
    $a20 = array('десять', 'одиннадцать', 'дванадцать', 'тринадцать', 'чотирнадцать', 'пятнадцать', 'шістнадцать', 'сімнадцать', 'вісімнадцать', 'девятнадцять');
    $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятдесят', 'шістьдесят', 'сімдесят', 'вісімьдесят', 'девяносто');
    $hundred = array('', 'сто', 'двісті', 'триста', 'чотириста', 'пятсот', 'шістсот', 'сімсот', 'вісімсот', 'девятсот');
    $unit = array( // Units
        array('копійка', 'копійки', 'копійок', 1),
        array('гривня', 'гривні', 'гривнів', 0),
        array('тисяча', 'тисячі', 'тисяч', 1),
        array('мільйон', 'мільйони', 'мільйонів', 0),
        array('мільярд', 'мільярди', 'мільярдів', 0),
    );
    //
    list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub) > 0) {
        foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit) - $uk - 1; // unit key
            $gender = $unit[$uk][3];
            list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
            else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk > 1) $out[] = morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
        } //foreach
    } else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
    $out[] = $kop . ' ' . morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5)
{
    $n = abs(intval($n)) % 100;
    if ($n > 10 && $n < 20) return $f5;
    $n = $n % 10;
    if ($n > 1 && $n < 5) return $f2;
    if ($n == 1) return $f1;
    return $f5;
}
