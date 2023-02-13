<?php

namespace app\assets;

use yii\web\AssetBundle;

class LoaderAsset extends AssetBundle
{
    public $js = [
        'js/loader.js',
    ];

    public $depends = [
        'app\assets\AdminAsset',
    ];
}
