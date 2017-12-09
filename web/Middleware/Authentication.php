<?php

namespace Web\Middleware;

use Web\App\Middleware;
use RedBeanPHP\R;

/**
 * Class Authentication
 * @package Web\Middleware
 *
 * Автентифікація користувача
 */
class Authentication extends Middleware
{
    /**
     * Обробник посередника
     * Провірка куків і оновлення сесії
     */
    public function handle()
    {
        if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
            if (R::count('users', '`login` = ? AND `password` = ?', [$_COOKIE['login'], $_COOKIE['password']])) {
                $_SESSION['login'] = $_COOKIE['login'];
                $_SESSION['password'] = $_COOKIE['password'];
            } else {
                $this->login_form();
            }
        } elseif (isset($_SESSION['login']) && isset($_SESSION['password'])) {
            if (!R::count('users', '`login` = ? AND `password` = ?', [$_SESSION['login'], $_SESSION['password']])) {
                $this->login_form();
            }
        } else {
            $this->login_form();
        }
    }

    /**
     * Ящо користувач не авторизований
     */
    private function login_form()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->display_login();
        } else {
            $this->response_not_authorized();
        }
    }
}