<?php

namespace app\user\actions;

use yii\web\Response;

class Action extends \yii\base\Action
{
    public $returnUrl;

    public function redirectTo($defaultActionId = 'index'): Response
    {
        if ($this->returnUrl !== null) {
            return $this->controller->redirect($this->returnUrl);
        }

        return $this->controller->redirect($defaultActionId);
    }
}
