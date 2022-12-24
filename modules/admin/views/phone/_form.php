<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Phone $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="phone-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
