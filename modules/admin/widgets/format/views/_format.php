<?php

/**
 * @var array $fragments
 * @var string $input
 */
?>

<div class="form-group">
    <?= $input ?>
    <a href="#" class="text-danger" id="clear-format"><?= Yii::t('fragments', 'Clear') ?></a>&nbsp;
    <a href="#" class="text-success" id="insert-dummy"><?= Yii::t('fragments', 'Dummy') ?></a>&nbsp;
    <?php foreach ($fragments as $fragment): ?>
        <a href="#" class="select-format" hidden-name="<?= $fragment ?>"><?= Yii::t('fragments', $fragment) ?></a>&nbsp;
    <?php endforeach; ?>
</div>