<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-backend-profile-tabs-_update_profile">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['update-profile']),
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-10',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'disabled' => Yii::$app->user->can(\modules\rbac\models\Role::ROLE_SUPER_ADMIN) ? false : true,
        'placeholder' => Module::t('module', 'Username'),
    ]) ?>

    <?= $form->field($model, 'email')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Email'),
    ]) ?>

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
