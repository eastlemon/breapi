<?php

use yii\base\DynamicModel;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var $model DynamicModel */

$this->title = Yii::t('app', 'Search');
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'search')->textInput()->label(Yii::t('app', 'Search String')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>