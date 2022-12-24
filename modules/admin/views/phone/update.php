<?php

/** @var yii\web\View $this */
/** @var app\models\Phone $model */

$this->title = Yii::t('app', 'Update');
?>

<div class="phone-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
