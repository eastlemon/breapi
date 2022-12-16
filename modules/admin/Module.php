<?php

namespace app\modules\admin;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'account';
    public $layout = 'main';
    public $controllerNamespace = 'app\modules\admin\controllers';
}
