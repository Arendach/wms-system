<?php

namespace Web\App;

use RedBeanPHP\R;
use Web\Model\User as Model;

class User extends Entity
{
    /**
     * @return array
     *
     * USER init
     */
    public function init()
    {
        $user = Model::getMe();
        return [
            'access' => $this->setAccess($user->access),
            'id' => $user->id,
            'login' => $user->login,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    private function setAccess($id)
    {
        if (R::count('users_access', '`id` = ?', [$id]) > 0) {
            $bean = R::load('users_access', $id);
            return json_decode($bean->params);
        } elseif ($id == 9999) {
            return true;
        } elseif ($id == 0) {
            return false;
        } else {
            $this->access_group_not_found();
        }
    }
}