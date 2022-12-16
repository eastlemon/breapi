<?php
/** @var ActiveRecord $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;

$this->title = Yii::t('user', 'Recover Password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('user', 'Please fill out your email. A link to reset password will be sent there.') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'email') ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('user', 'Send'), ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>