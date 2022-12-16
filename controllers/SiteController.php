<?php

namespace app\controllers;

use JetBrains\PhpStorm\ArrayShape;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\user\traits\EventTrait;

class SiteController extends Controller
{
    use EventTrait;

    #[ArrayShape(['access' => "array", 'verbs' => "array"])]
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'index',
                    'login',
                    'logout',
                    'request-password-reset',
                    'password-reset',
                    'account',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'request-password-reset', 'password-reset'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'logout', 'account'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'account' => ['get', 'post'],
                    'login' => ['get', 'post'],
                    'logout' => ['post'],
                    'request-password-reset' => ['get', 'post'],
                    'password-reset' => ['get', 'post'],
                ],
            ],
        ];
    }

    #[ArrayShape(['error' => "string[]", 'login' => "string[]", 'logout' => "string[]", 'request-password-reset' => "string[]", 'password-reset' => "string[]"])]
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'login' => [
                'class' => 'app\user\actions\LoginAction',
            ],
            'logout' => [
                'class' => 'app\user\actions\LogoutAction',
            ],
            'request-password-reset' => [
                'class' => 'app\user\actions\RequestPasswordResetAction',
            ],
            'password-reset' => [
                'class' => 'app\user\actions\PasswordResetAction',
            ],
        ];
    }

    public function actionIndex(): Response
    {
        return $this->redirect('admin');
    }
}
