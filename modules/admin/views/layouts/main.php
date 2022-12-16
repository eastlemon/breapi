<?php

/** @var string $content */

use app\assets\AppAsset;
use app\assets\AdminAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);
AdminAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
            <div class="d-flex" id="wrapper">
                <?= $this->render('sidebar') ?>
                <div id="page-content-wrapper">
                    <?= $this->render('navbar') ?>
                    <div class="container-fluid pt-4">
                        <?= $this->render('content', ['content' => $content]) ?>
                    </div>
                </div>
            </div>
        <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage() ?>