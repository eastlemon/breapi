<?php

namespace app\modules\admin\models;

use app\models\Fio as BaseFio;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Fio extends BaseFio
{
    public function __construct(int $inn, int $year, string $fio, $config = [])
    {
        parent::__construct($config);

        $this->id_inn = $inn;
        $this->year = $year;
        $this->fio = $fio;
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
