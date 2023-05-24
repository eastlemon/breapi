<?php

use app\user\models\UserModel;
use yii\helpers\Html;

/* @var $user UserModel */
    
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/password-reset', 'token' => $user->password_reset_token]);
?>

Hello <?= Html::encode($user->username) ?>,

Follow the link below to reset your password:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>