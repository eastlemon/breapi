<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fio".
 *
 * @property int $id
 * @property int $id_inn INN
 * @property int $year Year
 * @property string $fio Full Name
 * @property string|null $created_at Creation Time
 * @property string|null $updated_at Updation Time
 *
 * @property Inn $inn
 */
class Fio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_inn', 'year', 'fio'], 'required'],
            [['id_inn', 'year'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['fio'], 'string', 'max' => 255],
            [['id_inn'], 'exist', 'skipOnError' => true, 'targetClass' => Inn::class, 'targetAttribute' => ['id_inn' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_inn' => Yii::t('app', 'Id Inn'),
            'year' => Yii::t('app', 'Year'),
            'fio' => Yii::t('app', 'Fio'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Inn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInn()
    {
        return $this->hasOne(Inn::class, ['id' => 'id_inn']);
    }
}
