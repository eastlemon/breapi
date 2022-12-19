<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

class SettingsController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
