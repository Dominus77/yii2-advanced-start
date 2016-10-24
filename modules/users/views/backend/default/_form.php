<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
            <?= $form->field($model, 'role')->dropDownList($model->rolesArray, [
                'class' => 'form-control',
                'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
            ]) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'status')->dropDownList($model->statusesArray, [
                'class' => 'form-control',
            ]) ?>
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
