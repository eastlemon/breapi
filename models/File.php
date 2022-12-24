<?php

namespace app\models;

use app\modules\admin\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property int $id_user User Owner
 * @property string $name File Name
 * @property string $uniq_name File Unique Name
 * @property string $target File Target
 * @property string $ext File Extension
 * @property int|null $is_new Delete Flag
 * @property string|null $created_at Creation Time
 * @property string|null $updated_at Updation Time
 *
 * @property User $user
 */
class File extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id_user', 'name', 'uniq_name', 'target', 'ext'], 'required'],
            [['id_user', 'is_new'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'uniq_name', 'target', 'ext'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'uniq_name' => Yii::t('app', 'Uniq Name'),
            'target' => Yii::t('app', 'Target'),
            'ext' => Yii::t('app', 'Ext'),
            'is_new' => Yii::t('app', 'Is New'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
