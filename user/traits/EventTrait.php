<?php

namespace app\user\traits;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use app\user\events\CreateUserEvent;
use app\user\events\FormEvent;
use app\user\models\UserModel;

trait EventTrait
{
    /**
     * @throws InvalidConfigException
     */
    protected function getFormEvent(Model $form): object
    {
        return Yii::createObject(['class' => FormEvent::class, 'form' => $form]);
    }

    /**
     * @throws InvalidConfigException
     */
    protected function getCreateUserEvent(UserModel $user): object
    {
        return Yii::createObject(['class' => CreateUserEvent::class, 'user' => $user]);
    }
}
