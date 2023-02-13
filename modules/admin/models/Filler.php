<?php

namespace app\modules\admin\models;

use app\models\Filler as BaseFiller;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Filler extends BaseFiller
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
