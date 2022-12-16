<?php

namespace app\user\commands;

use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use app\user\models\UserModel;

class UpdatePasswordController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionIndex($email, $password): int
    {
        $user = UserModel::findByEmail($email);

        if ($user === null) {
            $this->stdout(Yii::t('user', 'User is not found.') . "\n", BaseConsole::FG_RED);
        } else {
            if ($user->resetPassword($password)) {
                $this->stdout(Yii::t('user', 'Password has been changed.') . "\n", BaseConsole::FG_GREEN);
            } else {
                $this->stdout(Yii::t('user', 'Error occurred while changing password.') . "\n", BaseConsole::FG_RED);
            }
        }

        return ExitCode::OK;
    }
}
