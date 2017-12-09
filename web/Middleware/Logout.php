<?php

namespace Web\Middleware;

use Web\App\Middleware;

class Logout extends Middleware
{
    public function handle()
    {
        unset($_SESSION['login']);
        unset($_SESSION['password']);
        setcookie ('login', "", time() - 1);
        setcookie ('password', "", time() - 1);
        $this->redirect(route('index'));
        exit;
    }
}