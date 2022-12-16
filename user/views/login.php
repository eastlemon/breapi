<?php
/** @var ActiveRecord $model */

use himiklab\yii2\recaptcha\ReCaptcha2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="static-page">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('user', 'Please fill out the following fields to login:') ?></p>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha2::class)->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    <?= Html::a(Yii::t('user', 'Forgot your password?'), ['site/request-password-reset']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>