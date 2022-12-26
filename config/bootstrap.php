<?php

namespace app\config;

use Yii;
use yii\base\BootstrapInterface;
use yii\widgets\LinkPager;
use yii\bootstrap5\LinkPager as LinkPager5;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
	{
        $container = Yii::$container;

        $container->set('yii\grid\SerialColumn', [
            'contentOptions' => ['style' => ['width' => '1px']],
        ]);
        
        $container->set('yii\grid\CheckboxColumn', [
            'contentOptions' => ['style' => ['width' => '1px']],
        ]);
        
        $container->set('yii\grid\ActionColumn', [
            'contentOptions' => ['style' => ['width' => '1px', 'white-space' => 'nowrap']],
        ]);

        $container->setDefinitions([
            LinkPager::class => LinkPager5::class,
        ]);
	}
}
