<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\Access;

class AccessController extends Controller
{
    /**
     * @GET
     */
    public function access_groups()
    {
        $data = [
            'title' => 'Менеджери :: Групи доступу',
            'section' => 'Групи доступу',
            'script' => 'managers/access.js',
            'groups' => Access::getAll(),
            'components' => ['breadcrumbs', 'sweet_alert']
        ];
        $this->view->display('/access/groups', $data);
    }

    /**
     * @GET
     * @param $id
     */
    public function access_group($id)
    {
        $data = [
            'title' => 'Менеджери :: Налаштування доступу',
            'group' => Access::getOne($id),
            'components' => ['breadcrumbs', 'sweet_alert'],
            'scripts' => ['managers/access.js'],
            'access' => Access::get_access($id)
        ];

        $this->view->display('/access/group', $data);
    }

    /**
     * @param $post
     */
    public function update_group($post)
    {
        Access::update_group($post->data, $post->id);
    }

    /**
     * @GET
     */
    public function access_group_create()
    {
        $data = [
            'title' => 'Менеджери :: Створення групи доступу',
            'section' => 'Створення групи доступу',
            'components' => ['breadcrumbs', 'sweet_alert'],
            'scripts' => ['managers/access.js'],
            'access' => Access::get_all()
        ];
        $this->view->display('/access/create', $data);
    }

    /**
     * @param $post
     */
    public function access_group_create_post($post)
    {
        Access::access_group_create($post);
    }

    /**
     * @param $post
     */
    public function group_delete($post)
    {
        Access::group_delete($post);
    }
}