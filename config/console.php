<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['app\config\bootstrap', 'log', 'loader'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\user\models\UserModel',
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/user/messages',
                ],
            ],
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
        ],
        'loader' => [
            'class' => \yii\queue\redis\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'redis' => 'redis',
            'channel' => 'loader',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'app\user\ConsoleModule',
            'controllerNamespace' => 'app\user\commands',
        ],
        'rbac' => [
            'class' => 'yii2mod\rbac\ConsoleModule',
        ],
    ],
    'params' => $params,
    'controllerMap' => [
        // php yii migrate/up --migrationPath=@app/user/migrations
        'setup-user' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@app/user/migrations',
        ],
        // php yii migrate/up --migrationPath=@yii/rbac/migrations
        'setup-rbac' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@yii/rbac/migrations',
        ],
        // php yii migrate --migrationPath=@vendor/yii2mod/yii2-settings/migrations
        'setup-settings' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@vendor/yii2mod/yii2-settings/migrations',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    // configuration adjustments for 'dev' environment
    // requires version `2.1.21` of yii2-debug module
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
