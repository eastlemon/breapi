<?php

namespace app\user\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    protected $user;

    public function rules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => UserModel::class, 'message' => Yii::t('user', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => UserModel::class, 'message' => Yii::t('user', 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
        ];
    }

    /**
     * @throws Exception
     */
    public function signup(): ?UserModel
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user = new UserModel();
        $this->user->setAttributes($this->attributes);
        $this->user->setPassword($this->password);
        $this->user->setLastLogin(time());
        $this->user->generateAuthKey();

        return $this->user->save() ? $this->user : null;
    }
    
    public function getUser()
    {
        return $this->user;
    }
}
