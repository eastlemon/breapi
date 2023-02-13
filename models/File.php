<?php

namespace app\models;

use app\modules\admin\models\User;
use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property int $id_user User Owner
 * @property string $name File Name
 * @property string $uniq_name File Unique Name
 * @property string $target File Target
 * @property string $ext File Extension
 * @property string|null $created_at Creation Time
 * @property string|null $updated_at Updation Time
 *
 * @property Filler[] $fillers
 * @property User $user
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'name', 'uniq_name', 'target', 'ext'], 'required'],
            [['id_user'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'uniq_name', 'target', 'ext'], 'string', 'max' => 255],
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
            'uniq_name' => Yii::t('app', 'Uniq Name'),
            'target' => Yii::t('app', 'Target'),
            'ext' => Yii::t('app', 'Ext'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Fillers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFillers()
    {
        return $this->hasMany(Filler::class, ['id_file' => 'id']);
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
