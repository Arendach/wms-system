<?php

namespace Web\Model;

use RedBeanPHP\R;
use Web\App\Security;
use Web\App\Session;
use Web\Model\Settings\BasicModel as Model;

class User extends Model
{
    const  table = 'users';

    /**
     * @return bool|\RedBeanPHP\OODBBean
     */
    public static function getMe()
    {
        if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
            return R::findOne('users', '`login` = ? AND `password` = ?', [$_SESSION['login'], $_SESSION['password']]);
        } else {
            return false;
        }
    }

    /**
     * Обробка форми авторизації
     * @param $data
     */
    public static function post_login($data)
    {
        $is = R::count('users', '`login` = ? AND `password` = ?', [$data->login, my_hash($data->password)]);

        if ($is) {
            $user = R::findOne('users', '`login` = ? AND `password` = ?', [$data->login, my_hash($data->password)]);

            $_SESSION['login'] = $user->login;
            $_SESSION['password'] = $user->password;

            if ($data->remember_me == '1') {
                setcookie('login', $user->login, time() + 3600 * 12 * 365);
                setcookie('password', $user->password, time() + 3600 * 12 * 365);
            }

            response(200);
        } else {
            response(400, 'Введені вами пароль або логін не вірні!');
        }
    }

    /**
     * @param $post
     */
    public static function register($post)
    {
        $bean = R::dispense('users');
        foreach ($post as $key => $value)
            $bean->$key = $value;

        $bean->password = my_hash($post->password);
        $bean->created_at = date('Y-m-d h:i:s');
        $bean->updated_at = date('Y-m-d h:i:s');
        R::store($bean);

        response(200, 'Дані успішно збережено!');
    }

    /**
     * RESET PASSWORD
     * @param $email
     */
    public static function reset($email)
    {
        if (!R::count('users', '`email` = ?', [$email]))
            response(400, 'Такий E-Mail не зареєстрований!');

        $password = Security::generateCode();

        $bean = R::findOne('users', '`email` = ?', [$email]);
        $bean->password = my_hash($password);
        R::store($bean);

        $subject = 'Скидання паролю';
        $message = date('Y-m-d') . " Ваш новий пароль: \"$password\"";
        $headers = 'From: roma4891@ukr.net' . "\r\n" .
            'Reply-To: roma4891@ukr.net' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers);
        response(200, '');
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getAccess($id)
    {
        return R::load('users_access', $id);
    }
}
