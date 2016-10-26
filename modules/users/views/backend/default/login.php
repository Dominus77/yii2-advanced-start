<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\users\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

$this->title = Module::t('backend', 'TITLE_LOGIN');
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="login-box-msg"><?= Module::t('backend', 'TEXT_LOGIN_START_SESSION'); ?></p>

<?php $form = ActiveForm::begin([
    'id' => 'login-form'
]); ?>

<div class="form-group has-feedback">
    <?= $form->field($model, 'email')->textInput([
        'class' => 'form-control',
        'placeholder' => Module::t('backend', 'EMAIL')
    ])->label(false); ?>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>

<div class="form-group has-feedback">
    <?= $form->field($model, 'password')->passwordInput([
        'class' => 'form-control',
        'placeholder' => Module::t('backend', 'PASSWORD')
    ])->label(false); ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>

<div class="row">
    <div class="col-xs-8">
        <div class="checkbox icheck">
            <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'iCheck']); ?>
        </div>
    </div>
    <div class="col-xs-4">
        <?= Html::submitButton(Module::t('backend', 'BUTTON_SIGN_IN'), [
            'class' => 'btn btn-primary btn-block btn-flat',
            'name' => 'login-button'
        ]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
