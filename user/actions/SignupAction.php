<?php

namespace app\user\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\user\traits\EventTrait;

class SignupAction extends Action
{
    use EventTrait;

    const EVENT_BEFORE_SIGNUP = 'beforeSignup';
    const EVENT_AFTER_SIGNUP = 'afterSignup';

    public $view = '@app/user/views/signup';
    public $modelClass = 'app\user\models\SignupForm';

    /**
     * @throws InvalidConfigException
     */
    public function run(): Response|array|string
    {
        $model = Yii::createObject($this->modelClass);
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_SIGNUP, $event);

        $load = $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($load && ($user = $model->signup()) !== null) {
            $this->trigger(self::EVENT_AFTER_SIGNUP, $event);
            if (Yii::$app->getUser()->login($user)) {
                return $this->redirectTo(Yii::$app->getUser()->getReturnUrl());
            }
        }

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
