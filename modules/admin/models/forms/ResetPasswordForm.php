<?php

namespace app\modules\admin\models\forms;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\IdentityInterface;

class ResetPasswordForm extends Model
{
    public $password;
    public $confirmPassword;
    private IdentityInterface $_user;

    public function __construct(IdentityInterface $user, array $config = [])
    {
        $this->_user = $user;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['password', 'confirmPassword'], 'trim'],
            ['password', 'required'],
            ['confirmPassword', 'required'],
            [['password', 'confirmPassword'], 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    #[ArrayShape(['password' => "string", 'confirmPassword' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'password' => Yii::t('app', 'New Password'),
            'confirmPassword' => Yii::t('app', 'Confirm New Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset
     * @throws Exception
     */
    public function resetPassword(): bool
    {
        if ($this->validate()) {
            $this->_user->setPassword($this->password);

            return $this->_user->save();
        }

        return false;
    }
}