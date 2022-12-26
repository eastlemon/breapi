<?php

namespace app\modules\admin\models;

use app\models\Tag as BaseTag;
use Yii;

class Tag extends BaseTag
{
    public function init()
    {
        parent::init();

        $this->id_user = Yii::$app->user->id;
    }
}
