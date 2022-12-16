<?php

namespace app\user\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\user\traits\EventTrait;

class RequestPasswordResetAction extends Action
{
    use EventTrait;

    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    public $view = '@app/user/views/requestPasswordResetToken';
    public $modelClass = 'app\user\models\PasswordResetRequestForm';
    public $successMessage = 'Check your email for further instructions.';
    public $errorMessage = 'Sorry, we are unable to reset password for email provided.';

    /**
     * @throws InvalidConfigException
     */
    public function run(): Response|array|string
    {
        $model = Yii::createObject($this->modelClass);
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REQUEST, $event);

        $load = $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($load && $model->validate()) {
            if ($model->sendEmail()) {
                $this->trigger(self::EVENT_AFTER_REQUEST, $event);
                Yii::$app->getSession()->setFlash('success', $this->successMessage);

                return $this->redirectTo(Yii::$app->getHomeUrl());
            } else {
                Yii::$app->getSession()->setFlash('error', $this->errorMessage);
            }
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
