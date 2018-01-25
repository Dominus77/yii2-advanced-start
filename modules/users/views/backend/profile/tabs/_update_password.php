<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\users\widgets\passfield\Passfield;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-backend-profile-tabs-_update_password">
    <?php
    $model->scenario = $model::SCENARIO_PASSWORD_UPDATE;
    $form = ActiveForm::begin([
        'action' => Url::to(['update-password']),
        'validationUrl' => ['ajax-validate-password-form'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-10',
            ],
        ],
    ]);
    ?>

    <?= Passfield::widget([
        'form' => $form,
        'model' => $model,
        'attribute' => 'newPassword',
        'options' => [
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('module', 'New Password'),
        ],
        'config' => [
            'locale' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '-')),
            'showToggle' => true,
            'showGenerate' => true,
            'showWarn' => true,
            'showTip' => true,
            'length' => [
                'min' => $model::LENGTH_STRING_PASSWORD_MIN,
                'max' => $model::LENGTH_STRING_PASSWORD_MAX,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Repeat Password'),
    ]) ?>

    <?= $form->field($model, 'currentPassword', ['enableAjaxValidation' => true])->passwordInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Current Password'),
    ]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Save'), [
                'class' => 'btn btn-primary',
                'name' => 'submit-button',
            ]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
