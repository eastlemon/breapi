<?php

namespace app\user\actions;

use Yii;
use yii\web\Response;

class LogoutAction extends Action
{
    public function run(): Response
    {
        Yii::$app->user->logout();

        return $this->redirectTo(Yii::$app->getHomeUrl());
    }
}
