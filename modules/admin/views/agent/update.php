<?php

/** @var yii\web\View $this */
/** @var app\models\Agent $model */

$this->title = Yii::t('app', 'Update Agent: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="agent-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
