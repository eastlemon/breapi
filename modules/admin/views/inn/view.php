<?php

use app\models\Fio;
use app\models\Phone;
use yii\bootstrap5\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Inn $model */
/** @var app\modules\admin\models\search\FioSearch $fioSearch */
/** @var yii\data\ActiveDataProvider $fioProvider */
/** @var app\modules\admin\models\search\PhoneSearch $phoneSearch */
/** @var yii\data\ActiveDataProvider $phoneProvider */

$this->title = $model->inn;
YiiAsset::register($this);
?>

<div class="inn-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'inn',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $fioProvider,
        'filterModel' => $fioSearch,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fio',
            'year',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::class,
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, Fio $model) {
                    return Url::toRoute(['fio/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]) ?>

    <hr>

    <?= GridView::widget([
        'dataProvider' => $phoneProvider,
        'filterModel' => $phoneSearch,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'phone',
            'year',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::class,
                'template' => '{update} {delete}',
                'urlCreator' => function ($action, Phone $model) {
                    return Url::toRoute(['phone/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]) ?>

</div>
