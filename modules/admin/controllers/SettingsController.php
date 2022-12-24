<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\base\DynamicModel;
use yii\web\Controller;
use yii\web\Response;

class SettingsController extends Controller
{
    public function actionIndex(): Response|string
    {
        $model = new DynamicModel(['start_year']);
        $model->addRule('start_year', 'required');
        $model->addRule('start_year', 'integer');

        $model->start_year = Yii::$app->settings->get('common', 'start_year');

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->settings->set('common', 'start_year', $model->start_year);

            return $this->redirect('settings/index');
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
