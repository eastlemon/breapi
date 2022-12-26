<?php

/** @var yii\web\View $this */
/** @var app\models\Tag $model */

$this->title = Yii::t('app', 'Update');
?>

<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
