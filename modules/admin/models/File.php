<?php

namespace app\modules\admin\models;

use app\models\File as BaseFile;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class File extends BaseFile
{
    public function init()
    {
        $this->id_user = Yii::$app->user->id;

        parent::init();
    }

    public function rules(): array
    {
        return [
            [['id_user'], 'integer'],
            [['name', 'uniq_name', 'target', 'ext', 'created_at', 'updated_at'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
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

    public static function findByName(string $name): ?BaseFile
    {
        return static::findOne(['uniq_name' => $name]);
    }
}
