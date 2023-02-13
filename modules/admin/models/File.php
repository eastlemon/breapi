<?php

namespace app\modules\admin\models;

use app\models\File as BaseFile;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class File extends BaseFile
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
