<?php

namespace app\modules\admin\models;

use app\user\models\UserModel;
use Yii;
use yii\base\Exception;

class User extends UserModel
{
    const ORIGINAL_USER_SESSION_KEY = 'ghjfhjdd';

    /**
     * @throws Exception
     */
    public static function generatePassword($length = 7): string
    {
        return Yii::$app->getSecurity()->generateRandomString($length);
    }
}
