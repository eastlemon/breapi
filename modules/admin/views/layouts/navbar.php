<?php

use yii\bootstrap5\Html;

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <button class="btn btn-outline-secondary" id="sidebarToggle"><?= Yii::t('app', 'Hide menu') ?></button>
        <?php if (Yii::$app->controller->id == 'tag'): ?>
            <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-outline-success ms-1']) ?>
        <?php endif; ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <li class="nav-item active"><a class="nav-link" href="/admin/fill"><?= Yii::t('app', 'Fill') ?></a></li>
                <li class="nav-item active"><a class="nav-link" href="/admin/load"><?= Yii::t('app', 'Load') ?></a></li>
                <li class="nav-item active"><a class="nav-link" href="/admin/search"><?= Yii::t('app', 'Search') ?></a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= Yii::t('app', 'Options') ?></a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/admin/account"><?= Yii::t('app', 'Account') ?></a>
                        <a class="dropdown-item" href="/admin/settings"><?= Yii::t('app', 'Settings') ?></a>
                        <div class="dropdown-divider"></div>
                        <?= Html::a(Yii::t('app', 'Logout'), ['/site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>