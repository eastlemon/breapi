<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "requisite".
 *
 * @property int $id
 * @property int $id_agent Agent
 * @property int $year Year
 * @property string|null $full_name Full Name
 * @property string|null $phone Phone Number
 * @property string|null $created_at Creation Time
 * @property string|null $updated_at Updation Time
 * @property int|null $is_del Delete Flag
 *
 * @property Agent $agent
 */
class Requisite extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'requisite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id_agent', 'year'], 'required'],
            [['id_agent', 'year', 'is_del'], 'integer'],
            [['full_name'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['phone'], 'string', 'max' => 255],
            [['id_agent'], 'exist', 'skipOnError' => true, 'targetClass' => Agent::class, 'targetAttribute' => ['id_agent' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_agent' => Yii::t('app', 'Id Agent'),
            'year' => Yii::t('app', 'Year'),
            'full_name' => Yii::t('app', 'Full Name'),
            'phone' => Yii::t('app', 'Phone'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'is_del' => Yii::t('app', 'Is Del'),
        ];
    }

    /**
     * Gets query for [[Agent]].
     *
     * @return ActiveQuery
     */
    public function getAgent(): ActiveQuery
    {
        return $this->hasOne(Agent::class, ['id' => 'id_agent']);
    }
}
