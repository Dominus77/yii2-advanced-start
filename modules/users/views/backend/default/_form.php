<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use modules\rbac\models\Rbac as BackendRbac;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-backend-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

        <div class="form-group">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true, 'class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'role')->widget(Select2::classname(), [
                'data' => $model->rolesArray,
                'language' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '-')),
                'theme' => Select2::THEME_DEFAULT,
                'options' => [
                    'placeholder' => Module::t('backend', 'SELECT_ROLE'),
                    'class' => 'form-control',
                    'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => $model->statusesArray,
                'language' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '-')),
                'theme' => Select2::THEME_DEFAULT,
                'options' => [
                    'placeholder' => Module::t('backend', 'SELECT_STATUS'),
                    'class' => 'form-control',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>

    <div class="box-footer">
        <div class="pull-right">
            <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-plus"></span> ' . Module::t('backend', 'BUTTON_CREATE') : '<span class="fa fa-floppy-o"></span> ' . Module::t('backend', 'BUTTON_SAVE'), [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'name' => 'submit-button',
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
