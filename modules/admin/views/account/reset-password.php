<?php

/* @var $this View */
/* @var $identity IdentityInterface */
/* @var $resetPasswordForm ResetPasswordForm */

use app\modules\admin\models\forms\ResetPasswordForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\IdentityInterface;
use yii\web\View;

$this->title = Yii::t('app', 'Change Password');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account'), 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($resetPasswordForm, 'password')->passwordInput() ?>

    <?= $form->field($resetPasswordForm, 'confirmPassword')->passwordInput() ?>

    <div class="form-group mb-0">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton(Yii::t('app', 'Cancel'), ['class' => 'btn btn-link']) ?>
    </div>
<?php ActiveForm::end(); ?>
