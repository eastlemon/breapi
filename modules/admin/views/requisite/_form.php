<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Requisite $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="requisite-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'year')->textInput() ?>

        <?= $form->field($model, 'full_name')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
