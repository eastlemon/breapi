<?php

use yii\base\DynamicModel;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var $model DynamicModel */

$this->title = Yii::t('app', 'Settings');
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'start_year')->textInput()->label(Yii::t('app', 'Start Year')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Load'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>