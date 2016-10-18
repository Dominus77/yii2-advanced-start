<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\users\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="login-box-msg"><?= Yii::t('app', 'Sign in to start your session'); ?></p>

<?php $form = ActiveForm::begin([
    'id' => 'login-form'
]); ?>

<div class="form-group has-feedback">
    <?= $form->field($model, 'email')->textInput([
        'class' => 'form-control',
        'placeholder' => Yii::t('app','Email')
    ])->label(false); ?>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>

<div class="form-group has-feedback">
    <?= $form->field($model, 'password')->passwordInput([
        'class' => 'form-control',
        'placeholder' => Yii::t('app','Password')
    ])->label(false); ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>

<div class="row">
    <div class="col-xs-8">
        <div class="checkbox icheck">
            <?= $form->field($model, 'rememberMe')->checkbox(); ?>
        </div>
    </div>
    <div class="col-xs-4">
        <?= Html::submitButton(Yii::t('app', 'Sign In'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
