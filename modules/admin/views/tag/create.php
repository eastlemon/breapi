<?php

/** @var yii\web\View $this */
/** @var app\models\Tag $model */

$this->title = Yii::t('app', 'Create');
?>

<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
