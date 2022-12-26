<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'name' => 'Reapi',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['app\config\bootstrap', 'log', 'loader1', 'loader2'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'nQM7JtHVkV15xo7kRL7HeXNTImPs4lo9',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\user\models\UserModel',
            'enableAutoLogin' => true,
            'on afterLogin' => function ($event) {
                $event->identity->updateLastLogin();
            },
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:404'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['jobs'],
                    'logFile' => '@app/runtime/logs/jobs.log',
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
                'app'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/user/messages',
                ],
            ],
        ],
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            'siteKeyV2' => '6Ld9aYMjAAAAAPb9-_9WnrIgYPXZx9-eqNUmyZHl',
            'secretV2' => '6Ld9aYMjAAAAALXofXGzFI4MTuX7cArrgMOzA9Mi',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'loader1' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'channel1', // Queue channel key
            'mutex' => \yii\mutex\FileMutex::class,
            'ttr' => 5 * 60, // Max time for job execution
            'attempts' => 3, // Max number of attempts
        ],
        'loader2' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'channel2', // Queue channel key
            'mutex' => \yii\mutex\FileMutex::class,
            'ttr' => 5 * 60, // Max time for job execution
            'attempts' => 3, // Max number of attempts
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'modules' => [
                'rbac' => [
                    'class' => 'yii2mod\rbac\Module',
                    'controllerMap' => [
                        'route' => [
                            'class' => 'yii2mod\rbac\controllers\RouteController',
                            'modelClass' => [
                                'class' => 'yii2mod\rbac\models\RouteModel',
                                'excludeModules' => ['debug', 'gii'],
                            ],
                        ],
                    ],
                ],
            ],
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
