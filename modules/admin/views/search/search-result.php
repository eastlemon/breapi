<?php

use app\models\Fio;
use app\models\Inn;
use app\models\Phone;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $inns ActiveDataProvider */
/* @var $phones ActiveDataProvider */
/* @var $fios ActiveDataProvider */

$this->title = Yii::t('app', 'Search Results');
?>

<?= GridView::widget([
    'dataProvider' => $inns,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'inn',
            'value' => function (Inn $data) {
                return Html::a(Html::encode($data->inn), Url::to(['inn/view', 'id' => $data->id]));
            },
            'format' => 'raw',
        ],
    ],
]) ?>

<?= GridView::widget([
    'dataProvider' => $phones,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'phone',
            'value' => function (Phone $data) {
                return Html::a(Html::encode($data->phone), Url::to(['inn/view', 'id' => $data->inn->id]));
            },
            'format' => 'raw',
        ],
    ],
]) ?>

<?= GridView::widget([
    'dataProvider' => $fios,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'fio',
            'value' => function (Fio $data) {
                return Html::a(Html::encode($data->fio), Url::to(['inn/view', 'id' => $data->inn->id]));
            },
            'format' => 'raw',
        ],
    ],
]) ?>