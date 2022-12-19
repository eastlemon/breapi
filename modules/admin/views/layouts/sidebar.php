<div class="border-end bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading"><a class="link-dark" href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->name ?></a></div>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= Yii::$app->controller->id == 'agent' ? 'active' : '' ?>" href="/admin/agent"><?= Yii::t('app', 'Agents') ?></a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3 <?= Yii::$app->controller->id == 'requisite' ? 'active' : '' ?>" href="/admin/requisite"><?= Yii::t('app', 'Requisites') ?></a>
    </div>
</div>