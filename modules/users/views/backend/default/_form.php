<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\rbac\models\Rbac as BackendRbac;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\backend\User */
/* @var $uploadModel modules\users\models\UploadForm */
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
        ],
        'options' => [
            'enctype' => 'multipart/form-data',

        ]
    ]); ?>
    <div class="box-body">
        <?= $form->field($model, 'imageFile')->fileInput() ?>

        <?= $form->field($model, 'username')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
            'placeholder' => Module::t('backend', 'USERNAME'),
        ]) ?>

        <?= $form->field($model, 'first_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('backend', 'FIRST_NAME'),
        ]) ?>

        <?= $form->field($model, 'last_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('backend', 'LAST_NAME'),
        ]) ?>

        <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            //'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
            'placeholder' => Module::t('backend', 'EMAIL'),
        ]) ?>

        <?= $form->field($model, 'newPassword')->passwordInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('backend', 'PASSWORD'),
        ]) ?>

        <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('backend', 'USER_REPEAT_PASSWORD'),
        ]) ?>

        <?= $form->field($model, 'role')->dropDownList($model->rolesArray, [
            'class' => 'form-control',
            'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
        ]) ?>

        <?= $form->field($model, 'status')->dropDownList($model->statusesArray, [
            'class' => 'form-control',
            'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
        ]) ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-plus"></span> ' . Module::t('backend', 'BUTTON_CREATE') : '<span class="fa fa-floppy-o"></span> ' . Module::t('backend', 'BUTTON_SAVE'), [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'name' => 'submit-button',
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
