<?php

namespace app\models;

use app\modules\admin\models\User;
use Yii;

/**
 * This is the model class for table "inn".
 *
 * @property int $id
 * @property int $id_user User Owner
 * @property string $inn INN
 * @property string|null $created_at Creation Time
 * @property string|null $updated_at Updation Time
 *
 * @property Fio[] $fios
 * @property Phone[] $phones
 * @property User $user
 */
class Inn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'inn'], 'required'],
            [['id_user'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['inn'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'Id User'),
            'inn' => Yii::t('app', 'Inn'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Fios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFios()
    {
        return $this->hasMany(Fio::class, ['id_inn' => 'id']);
    }

    /**
     * Gets query for [[Phones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhones()
    {
        return $this->hasMany(Phone::class, ['id_inn' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
