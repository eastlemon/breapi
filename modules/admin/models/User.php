<?php

namespace app\modules\admin\models;

use app\models\File;
use app\user\models\UserModel;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;

class User extends UserModel
{
    const ORIGINAL_USER_SESSION_KEY = 'ghjfhjdd';

    public function getFiles(): ActiveQuery
    {
        return $this->hasMany(File::class, ['id_user' => 'id']);
    }

    /**
     * @throws Exception
     */
    public static function generatePassword($length = 7): string
    {
        return Yii::$app->getSecurity()->generateRandomString($length);
    }
}
