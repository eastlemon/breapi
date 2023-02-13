<?php

use app\assets\FillerAsset;
use app\models\File;
use app\modules\admin\widgets\format\FormatWidget;
use yii\base\DynamicModel;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

FillerAsset::register($this);

/* @var $model DynamicModel */
/* @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Search');
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sheedFile')->fileInput(['class' => 'form-control-file'])->label(Yii::t('app', 'Select File')) ?>

    <?= $form->field($model, 'format')->widget(FormatWidget::class)->label(Yii::t('app', 'Format')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Fill'), ['class' => 'btn btn-success']) ?>
        <div class="btn">
            <?= Yii::t('app', 'Queue') ?>: <span id="loader-queue"><?= Yii::t('app', 'Just a second') ?></span>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<hr>

<div class="file-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'value' => function (File $data) {
                    return Html::a(Html::encode($data->name), Url::to(['download', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            'created_at',

            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
                'urlCreator' => function ($action, File $model) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]) ?>

</div>
