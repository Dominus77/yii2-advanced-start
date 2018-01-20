<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-backend-profile-update">
    <?php
    $model->scenario = $model::SCENARIO_ADMIN_UPDATE;
    $form = ActiveForm::begin([
        'action' => Url::to(['update-profile', 'id' => $model->id]),
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-10',
            ],
        ],
    ]); ?>
    <?php if (Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_USERS)) : ?>
        <?= $form->field($model, 'username')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'disabled' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_USERS) ? false : true,
            'placeholder' => Module::t('module', 'Username'),
        ]) ?>
    <?php endif ?>

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

    <?= $form->field($model, 'email')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Email'),
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
