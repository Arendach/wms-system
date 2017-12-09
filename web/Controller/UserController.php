<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\Access;
use Web\Model\User;

class UserController extends Controller
{
    public function get_login_form()
    {
        echo $this->view->render('/login');
    }

    public function post_login($data)
    {
        if (isset($data->login) && !empty($data->login) && isset($data->password) && !empty($data->password)) {
            User::post_login($data);
        } else {
            response(400, 'Введіть логін і пароль');
        }
    }

    public function all()
    {
        $data = [
            'title' => 'Менеджери',
            'section' => 'Менеджери',
            'link_css' => ['users.css'],
            'components' => ['breadcrumbs'],
            'items' => User::getAll()
        ];

        $this->view->display('/users/all', $data);
    }

    /**
     * @param $manager
     * @return mixed
     * Функція вертає назву групи доступу менеджера
     */
    public function get_access($manager)
    {
        if ($manager->access == 9999)
            $manager->access_name = 'ROOT';
        elseif ($manager->access == 0)
            $manager->access_name = 'Безправний';
        else {
            $access = User::getAccess($manager->access);
            if (!$access)
                $manager->access_name = 'Незнайдено';
            else {
                $manager->access_name = $access->name;
                $manager->access_link = true;
            }
        }

        return $manager;
    }

    /**
     * @GET
     * @param $id
     * Перегляд даних менеджера
     */
    public function manager_view($id)
    {
        $manager = User::getOne($id);
        if ($manager->id == 0)
            $this->redirect(route('404'));

        $manager = $this->get_access($manager);

        $data = [
            'title' => 'Менеджери :: ' . $manager->login,
            'components' => ['sweet_alert', 'breadcrumbs'],
            'id' => $id,
            'manager' => $manager
        ];

        $this->view->display('/users/manager_view', $data);
    }

    /**
     * @param $id
     * @GET
     */
    public function manager_edit($id)
    {
        $data = [
            'components' => ['breadcrumbs'],
            'scripts' => ['managers/managers.js'],
            'to_js' => ['id' => $id],
            'title' => 'Менеджери :: Редагування даних',
            'manager' => User::getOne($id),
            'access_groups' => get_object(Access::get_all_groups())
        ];

        $this->view->display('/users/manager_edit', $data);
    }


    /**
     * @POST
     * @param $post
     */
    public function update_info($post)
    {
        if (cannot('manager_update')) {
            echo 'У вас немає доспупу до даного розділу!';
            exit;
        }
        User::update($post->data, $post->id);
    }

    /**
     * @GET
     */
    public function register()
    {
        $data = [
            'scripts' => ['managers/managers.js'],
            'access_groups' => get_object(Access::getAll()),
            'title' => 'Менеджери :: Реєстрація',
            'components' => ['breadcrumbs', 'sweet_alert'],
            'route' => true
        ];

        $this->view->display('/users/register', $data);
    }


    /**
     * @POST
     */
    public function post_register($post)
    {
        $error = 0;
        foreach ($post as $key => $value)
            if (empty($value))
                $error++;

        if ($error > 0)
            response(400, 'Заповніть всі поля правильно!');

        if (!preg_match('/^[A-z0-9]+$/', $post->login) || strlen($post->login) < 3)
            response(400, 'Логін тільки англійські букви і цифри! Не менше 3 символів!');

        if (strlen($post->password) < 4 || !preg_match('/^[A-z0-9]+$/', $post->password))
            response(400, 'Пароль не може бути кортше 4 символів! Тільки англійські букви і цифри!');

        if (User::count('users', '`email` = ?', [$post->email]) > 0)
            response(400, 'Користувач з таким E-Mail уже існує в БД!');

        if (User::count('users', '`login` = ?', [$post->login]) > 0)
            response(400, 'Користувач з таким логіном уже існує в БД!');

        User::register($post);
    }

    /**
     * Сторінка мого профіля
     */
    public function profile()
    {
        $data = [
            'components' => ['breadcrumbs'],
            'title' => 'Мій профіль'
        ];
        $this->view->display('/users/profile/index', $data);
    }

    /**
     * @param $post
     */
    public function update_password($post)
    {
        if ($post->password != $post->password_confirmation)
            response(400, 'Паролі не співпадають');

        if (mb_strlen($post->password) < 6)
            response(400, 'Занадто короткий пароль!');

        User::update(['password' => my_hash($post->password)], $post->id);

        if ($post->id == user()->id) {
            $_SESSION['password'] = my_hash($post->password);
            setcookie('password', my_hash($post->password), time() + 3600 * 12 * 365);
        }
    }

    /**
     * @GET
     */
    public function post_update_password()
    {
        $data = [
            'title' => 'Профіль :: Зміна паролю',
            'components' => ['breadcrumbs'],
            'scripts' => ['managers/managers.js'],
            'to_js' => ['id' => user()->id]
        ];

        $this->view->display('/users/profile/update_password', $data);
    }

    public function get_reset_password()
    {
        $this->view->display('/pages/reset_password');
    }

    public function post_reset_password($post)
    {
        if (!isset($post->email) || !filter_var($post->email, FILTER_VALIDATE_EMAIL))
            response(200, 'Введіть коректний E-Mail');

        User::reset($post->email);
    }
}