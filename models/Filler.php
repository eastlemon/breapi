<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filler".
 *
 * @property int $id
 * @property int $id_file File
 * @property string $fio Full Name
 * @property string $inn INN
 * @property string $phone Phone Number
 * @property string|null $created_at Creation Time
 * @property string|null $updated_at Updation Time
 *
 * @property File $file
 */
class Filler extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filler';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_file', 'fio', 'inn', 'phone'], 'required'],
            [['id_file'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['fio', 'inn', 'phone'], 'string', 'max' => 255],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['id_file' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_file' => Yii::t('app', 'Id File'),
            'fio' => Yii::t('app', 'Fio'),
            'inn' => Yii::t('app', 'Inn'),
            'phone' => Yii::t('app', 'Phone'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'id_file']);
    }
}
