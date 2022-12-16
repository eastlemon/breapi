<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\forms\ResetPasswordForm;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class AccountController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index', [
            'identity' => Yii::$app->user->identity,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionResetPassword(): Response|string
    {
        $resetPasswordForm = new ResetPasswordForm(Yii::$app->user->identity);

        if ($resetPasswordForm->load(Yii::$app->request->post()) && $resetPasswordForm->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Password has been updated'));

            return $this->refresh();
        }

        return $this->render('reset-password', [
            'resetPasswordForm' => $resetPasswordForm,
        ]);
    }
}
