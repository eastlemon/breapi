<?php

namespace app\user\events;

use yii\base\Event;
use app\user\models\UserModel;

class CreateUserEvent extends Event
{
    private $_user;

    public function getUser()
    {
        return $this->_user;
    }

    public function setUser(UserModel $user)
    {
        $this->_user = $user;
    }
}
