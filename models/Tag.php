<?php

namespace app\models;

use app\modules\admin\models\User;
use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property int $id_user User Owner
 * @property string $name Tag
 *
 * @property Inn[] $inns
 * @property User $user
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'name'], 'required'],
            [['id_user'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[Inns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInns()
    {
        return $this->hasMany(Inn::class, ['id_tag' => 'id']);
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
