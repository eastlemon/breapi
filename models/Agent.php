<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "agent".
 *
 * @property int $id
 * @property int $id_user User Owner
 * @property string $inn INN
 * @property string|null $created_at Creation Time
 * @property string|null $updated_at Updation Time
 * @property int|null $is_del Delete Flag
 *
 * @property Requisite[] $requisites
 * @property User $user
 */
class Agent extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'agent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id_user', 'inn'], 'required'],
            [['id_user', 'is_del'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['inn'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'Id User'),
            'inn' => Yii::t('app', 'Inn'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'is_del' => Yii::t('app', 'Is Del'),
        ];
    }

    /**
     * Gets query for [[Requisites]].
     *
     * @return ActiveQuery
     */
    public function getRequisites(): ActiveQuery
    {
        return $this->hasMany(Requisite::class, ['id_agent' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
