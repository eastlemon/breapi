<?php

/** @var yii\web\View $this */
/** @var app\models\Fio $model */

$this->title = Yii::t('app', 'Update');
?>

<div class="fio-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
