<?php

namespace app\modules\admin\models;

use app\models\Inn as BaseInn;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Inn extends BaseInn
{
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
