<?php

namespace app\modules\admin\widgets\format;

use yii\web\AssetBundle;

class FormatWidgetAsset extends AssetBundle
{
    public $sourcePath = (__DIR__ . '/assets');
    public $js = [
        'js/format.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}