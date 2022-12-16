<?php

/* @var $this View */
/* @var $identity  */

use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'Account');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <?= Yii::t('app', 'Functions') ?>
            </div>
            <div class="card-body">
                <?= Html::a(Yii::t('app', 'Change Password'), ['account/reset-password'], ['class'=>'btn btn-outline-primary']) ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <?= Yii::t('app', 'Personal Information') ?>
            </div>
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $identity,
                    'attributes' => [
                        'username',
                        'email',
                        'last_login:date',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>