<?php

use app\modules\admin\widgets\format\FormatWidget;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/* @var $model app\modules\admin\models\forms\UploadForm */
/* @var $tags array */
/* @var $years array */

$this->title = Yii::t('app', 'Import');
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sheedFiles[]')->fileInput(['multiple' => true, 'class' => 'form-control-file']) ?>

    <?= $form->field($model, 'tag')->widget(Select2::class, [
        'data' => $tags,
        'options' => [
            'placeholder' => Yii::t('app', 'Select...'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(Yii::t('app', 'Tag')) ?>

    <?= $form->field($model, 'year')->dropDownList($years) ?>

    <?= $form->field($model, 'format')->widget(FormatWidget::class)->label(Yii::t('app', 'Format')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Load'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

<hr>

<p><?= Yii::t('app', 'Loader Queue') ?>: <span id="loader-queue"><?= Yii::t('app', 'Just a second') ?></span></p>
