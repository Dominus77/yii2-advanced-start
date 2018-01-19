<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\widgets\passfield\Passfield;
use modules\users\models\User;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-backend-form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-10',
            ],
        ]
    ]); ?>
    <div class="box-body">

        <?= $form->field($model, 'username')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('module', 'Username'),
        ]) ?>

        <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('module', 'Email'),
        ]) ?>

        <?= Passfield::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'newPassword',
            'label' => Module::t('module', 'Password'),
            'options' => [
                'maxlength' => true,
                'class' => 'form-control',
                'placeholder' => Module::t('module', 'Password'),
            ],
            'config' => [
                'locale' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '-')),
                'showToggle' => true,
                'showGenerate' => true,
                'showWarn' => true,
                'showTip' => true,
                'length' => [
                    'min' => User::LENGTH_STRING_PASSWORD_MIN,
                    'max' => User::LENGTH_STRING_PASSWORD_MAX,
                ]
            ],
        ]); ?>

        <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('module', 'Repeat Password'),
        ]) ?>

        <hr>

        <?= $form->field($model, 'first_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('module', 'First Name'),
        ]) ?>

        <?= $form->field($model, 'last_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('module', 'Last Name'),
        ]) ?>

        <hr>

        <?= $form->field($model, 'status')->dropDownList($model->statusesArray, [
            'class' => 'form-control',
        ]) ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-plus"></span> ' . Module::t('module', 'Create') : '<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Save'), [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'name' => 'submit-button',
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
