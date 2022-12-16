<?php

namespace app\user\models;

use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $password;

    protected $user;

    /**
     * @throws \Exception
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }

        $this->user = UserModel::findByPasswordResetToken($token);

        if (!$this->user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }

        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'password' => Yii::t('user', 'Password'),
        ];
    }

    /**
     * @throws Exception
     */
    public function resetPassword(): bool
    {
        $user = $this->user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save();
    }
}
