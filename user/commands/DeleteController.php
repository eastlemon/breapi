<?php

namespace app\user\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\StaleObjectException;
use yii\helpers\BaseConsole;
use app\user\models\UserModel;

class DeleteController extends Controller
{
    /**
     * @throws StaleObjectException
     */
    public function actionIndex($email): int
    {
        if ($this->confirm(Yii::t('user', 'Are you sure you want to delete this user?'))) {
            $user = UserModel::findByEmail($email);
            if ($user === null) {
                $this->stdout(Yii::t('user', 'User is not found.') . "\n", BaseConsole::FG_RED);
            } else {
                if ($user->delete()) {
                    $this->stdout(Yii::t('user', 'User has been deleted.') . "\n", BaseConsole::FG_GREEN);
                } else {
                    $this->stdout(Yii::t('user', 'Error occurred while deleting user.') . "\n", BaseConsole::FG_RED);
                }
            }
        }

        return ExitCode::OK;
    }
}
