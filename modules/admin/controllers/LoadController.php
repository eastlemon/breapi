<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

class LoadController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
