<?php

namespace app\user\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class LoginAction extends Action
{
    public $view = '@app/user/views/login';
    public $modelClass = 'app\user\models\LoginForm';
    public $layout;

    public function init()
    {
        if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }
        
        parent::init();
    }

    /**
     * @throws InvalidConfigException
     */
    public function run(): Response|array|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirectTo(Yii::$app->getHomeUrl());
        }

        $model = Yii::createObject($this->modelClass);
        $load = $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($load && $model->login()) {
            return $this->redirectTo(Yii::$app->getUser()->getReturnUrl());
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
