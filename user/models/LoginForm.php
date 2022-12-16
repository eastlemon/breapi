<?php

namespace app\user\models;

use Yii;
use yii\base\Model;
use app\user\models\enums\UserStatus;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    protected $user = false;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'rememberMe' => Yii::t('user', 'Remember Me'),
        ];
    }
    
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user && $user->status === UserStatus::DELETED) {
                $this->addError($attribute, Yii::t('user', 'Your account has been deactivated, please contact support for details.'));
            } elseif (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('user', 'Incorrect email or password.'));
            }
        }
    }
    
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
    
    public function getUser(): ?UserModel
    {
        if ($this->user === false) {
            $this->user = UserModel::findByEmail($this->email);
        }

        return $this->user;
    }
}
