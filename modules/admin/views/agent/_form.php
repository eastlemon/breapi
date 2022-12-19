<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Agent $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="agent-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
