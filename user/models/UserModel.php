<?php

namespace app\user\models;

use Exception;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use app\user\models\enums\UserStatus;
use app\user\traits\EventTrait;

class UserModel extends ActiveRecord implements IdentityInterface
{
    use EventTrait;
    
    const BEFORE_CREATE = 'beforeCreate';
    const AFTER_CREATE = 'afterCreate';

    public $plainPassword;

    public static function tableName(): string
    {
        return '{{%user}}';
    }
    
    public function rules(): array
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'unique', 'message' => Yii::t('user', 'This email address has already been taken.')],
            ['username', 'unique', 'message' => Yii::t('user', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['plainPassword', 'string', 'min' => 6],
            ['plainPassword', 'required', 'on' => 'create'],
            ['status', 'default', 'value' => UserStatus::ACTIVE],
            ['status', 'in', 'range' => UserStatus::getConstantsByName()],
            [['id_parent'], 'exist', 'skipOnError' => true, 'targetClass' => static::class, 'targetAttribute' => ['id_parent' => 'id']],
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'status' => Yii::t('user', 'Status'),
            'created_at' => Yii::t('user', 'Registration time'),
            'last_login' => Yii::t('user', 'Last login'),
            'plainPassword' => Yii::t('user', 'Password'),
        ];
    }
    
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function create(): ?UserModel
    {
        $transaction = $this->getDb()->beginTransaction();

        try {
            $event = $this->getCreateUserEvent($this);
            $this->trigger(self::BEFORE_CREATE, $event);

            $this->setPassword($this->plainPassword);
            $this->generateAuthKey();

            if (!$this->save()) {
                $transaction->rollBack();

                return null;
            }

            $this->trigger(self::AFTER_CREATE, $event);

            $transaction->commit();

            return $this;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::warning($e->getMessage());
            throw $e;
        }
    }
    
    public static function findIdentity($id): UserModel
    {
        return static::findOne($id);
    }

    /**
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    public static function findByUsername($username): ?UserModel
    {
        return static::findOne(['username' => $username, 'status' => UserStatus::ACTIVE]);
    }
    
    public static function findByEmail($email): ?UserModel
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * @throws Exception
     */
    public static function findByPasswordResetToken($token): ?UserModel
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => UserStatus::ACTIVE,
        ]);
    }

    /**
     * @throws Exception
     */
    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = ArrayHelper::getValue(Yii::$app->params, 'user.passwordResetTokenExpire', 3600);

        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public function validatePassword($password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }
    
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function setLastLogin($lastLogin)
    {
        $this->last_login = $lastLogin;
    }
    
    public function updateLastLogin()
    {
        $this->updateAttributes(['last_login' => time()]);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function resetPassword($password): bool
    {
        $this->setPassword($password);

        return $this->save(true, ['password_hash']);
    }

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'id_parent']);
    }

    public function getChilds(): array
    {
        $array = $this->hasMany(self::class, ['id_parent' => 'id'])->all();
        return ArrayHelper::getColumn($array, 'id');
    }
}
