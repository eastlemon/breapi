<?php

namespace app\user\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use app\user\models\enums\UserStatus;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules(): array
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => Yii::$app->user->identityClass,
                'message' => Yii::t('user', 'User with this email is not found.'),
            ],
            ['email', 'exist',
                'targetClass' => Yii::$app->user->identityClass,
                'filter' => ['status' => UserStatus::ACTIVE],
                'message' => Yii::t('user', 'Your account has been deactivated, please contact support for details.'),
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('user', 'Email'),
        ];
    }

    /**
     * @throws Exception
     */
    public function sendEmail(): bool
    {
        $user = UserModel::findOne(['status' => UserStatus::ACTIVE, 'email' => $this->email]);

        if (!empty($user)) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                return Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject(Yii::t('user', 'Password reset for {0}', Yii::$app->name))
                    ->send();
            }
        }

        return false;
    }
}
