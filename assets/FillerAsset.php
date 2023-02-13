<?php

namespace app\assets;

use yii\web\AssetBundle;

class FillerAsset extends AssetBundle
{
    public $js = [
        'js/filler.js',
    ];

    public $depends = [
        'app\assets\AdminAsset',
    ];
}
