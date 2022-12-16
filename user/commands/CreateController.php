<?php

namespace app\user\commands;

use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\helpers\BaseConsole;
use app\user\models\UserModel;

class CreateController extends Controller
{
    public function actionIndex($email, $username, $password)
    {
        try {
            $user = Yii::createObject([
                'class' => UserModel::class,
                'scenario' => 'create',
                'email' => $email,
                'username' => $username,
                'plainPassword' => $password,
            ]);

            try {
                if ($user->create()) {
                    $this->stdout(Yii::t('user', 'User has been created.') . "!\n", BaseConsole::FG_GREEN);
                } else {
                    $this->stdout(Yii::t('user', 'Please fix the following errors:') . "\n", BaseConsole::FG_RED);
                    foreach ($user->errors as $errors) {
                        foreach ($errors as $error) {
                            $this->stdout(' - ' . $error . "\n", BaseConsole::FG_RED);
                        }
                    }
                }
            } catch (Exception $e) {
            }
        } catch (InvalidConfigException $e) {
        }
    }
}
