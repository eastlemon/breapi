<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

class SearchController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
