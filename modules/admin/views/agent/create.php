<?php

/** @var yii\web\View $this */
/** @var app\models\Agent $model */

$this->title = Yii::t('app', 'Create Agent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="agent-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
