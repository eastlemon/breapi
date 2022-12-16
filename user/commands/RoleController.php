<?php

namespace app\user\commands;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use app\user\models\UserModel;

class RoleController extends Controller
{
    private $_authManager;

    public function init()
    {
        $this->_authManager = Yii::$app->authManager;
        
        parent::init();
    }

    /**
     * @throws Exception
     */
    public function actionAssign($roleName, $email): int
    {
        $user = UserModel::findByEmail($email);

        if (empty($user)) {
            throw new Exception(Yii::t('user', 'User is not found.'));
        }

        $role = $this->findRole($roleName);

        if (in_array($roleName, array_keys($this->_authManager->getRolesByUser($user->id)))) {
            $this->stdout(Yii::t('user', 'This role already assigned to this user.') . "\n", BaseConsole::FG_RED);

            return ExitCode::OK;
        }

        $this->_authManager->assign($role, $user->id);

        $this->stdout(Yii::t('user', 'The role has been successfully assigned to the user.') . "\n", BaseConsole::FG_GREEN);

        return ExitCode::OK;
    }

    /**
     * @throws Exception
     */
    public function actionRevoke($roleName, $email): int
    {
        $user = UserModel::findByEmail($email);

        if (empty($user)) {
            throw new Exception(Yii::t('user', 'User is not found.'));
        }

        $role = $this->findRole($roleName);

        if (!in_array($roleName, array_keys($this->_authManager->getRolesByUser($user->id)))) {
            $this->stdout(Yii::t('user', 'This role is not assigned to this user.') . "\n", BaseConsole::FG_RED);

            return ExitCode::OK;
        }

        $this->_authManager->revoke($role, $user->id);

        $this->stdout(Yii::t('user', 'The role has been successfully revoked from the user.') . "\n", BaseConsole::FG_GREEN);

        return ExitCode::OK;
    }

    /**
     * @throws Exception
     */
    protected function findRole($roleName)
    {
        if (($role = $this->_authManager->getRole($roleName)) !== null) {
            return $role;
        }

        throw new Exception(Yii::t('user', 'The role "{roleName}" is not found.', [
            'roleName' => $roleName,
        ]));
    }
}
