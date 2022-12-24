<?php

namespace app\modules\admin\models;

use app\models\Phone as BasePhone;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Phone extends BasePhone
{
    public function __construct(int $inn, int $year, string $phone, $config = [])
    {
        parent::__construct($config);

        $this->id_inn = $inn;
        $this->year = $year;
        $this->phone = $phone;
    }

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
