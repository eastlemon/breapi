<?php

namespace app\user\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use app\user\traits\EventTrait;

class PasswordResetAction extends Action
{
    use EventTrait;

    const EVENT_BEFORE_RESET = 'beforeReset';
    const EVENT_AFTER_RESET = 'afterReset';

    public $view = '@app/user/views/resetPassword';
    public $modelClass = 'app\user\models\ResetPasswordForm';
    public $successMessage = 'New password was saved.';

    /**
     * @throws InvalidConfigException
     * @throws BadRequestHttpException
     */
    public function run($token): \yii\web\Response|string
    {
        try {
            $model = Yii::createObject($this->modelClass, [$token]);
            $event = $this->getFormEvent($model);
            $this->trigger(self::EVENT_BEFORE_RESET, $event);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $this->trigger(self::EVENT_AFTER_RESET, $event);
            Yii::$app->getSession()->setFlash('success', $this->successMessage);

            return $this->redirectTo(Yii::$app->getHomeUrl());
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
