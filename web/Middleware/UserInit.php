<?php

namespace Web\Middleware;

use Web\App\Middleware;
use Web\App\User;

/**
 * Class UserInit
 * @package Web\Middleware
 *
 * Ініціалізація користувача
 *
 * Створюється константа USER з масивом даних про користувача
 *
 * access
 * id
 * login
 * email
 * first_name
 * last_name
 *
 */
class UserInit extends Middleware
{
    public function handle()
    {
        $u = new User();
        $GLOBALS['user_info_init'] = $u->init();
    }
}