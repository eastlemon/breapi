<?php

/** @var yii\web\View $this */
/** @var app\models\Inn $model */

$this->title = Yii::t('app', 'Update');
?>

<div class="inn-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
