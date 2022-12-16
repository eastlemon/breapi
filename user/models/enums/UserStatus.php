<?php

namespace app\user\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class UserStatus extends BaseEnum
{
    const ACTIVE = 1;
    const DELETED = 0;

    public static $messageCategory = 'user';

    public static $list = [
        self::ACTIVE => 'Active',
        self::DELETED => 'Deleted',
    ];
}
