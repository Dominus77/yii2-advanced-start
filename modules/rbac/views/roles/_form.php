<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rbac-roles-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-role',
        'enableAjaxValidation' => true,
        'validationUrl' => ['ajax-validate-form']
    ]); ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'disabled' => $model->scenario === $model::SCENARIO_UPDATE
    ])->hint(Module::t('module', 'Example: moderator')) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

    <?php if ($model->scenario === $model::SCENARIO_UPDATE) : ?>
        <div id="assign-container-roles">
            <div class="row">
                <div class="col-md-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-add-roles',
                        'action' => Url::to(['remove-roles'])
                    ]); ?>
                    <?= $form->field($model, 'rolesByRole')->listBox($model->getRolesByRole(), [
                        'multiple' => 'true',
                        'size' => 8
                    ])->label(Module::t('module', 'Roles by role')) ?>
                    <?= $form->field($model, 'name')->hiddenInput()->label(false) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-2">
                    <div class="text-center">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'form' => 'form-remove-roles']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'form' => 'form-add-roles']) ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-remove-roles',
                        'action' => Url::to(['add-roles'])
                    ]); ?>
                    <?= $form->field($model, 'itemsRoles')->listBox($model->getItemsRoles(), [
                        'multiple' => 'true',
                        'size' => 8
                    ]) ?>
                    <?= $form->field($model, 'name')->hiddenInput()->label(false) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <hr>
        <div id="assign-container-permissions">
            <div class="row">
                <div class="col-md-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-add-permissions',
                        'action' => Url::to(['remove-permissions'])
                    ]); ?>
                    <?= $form->field($model, 'permissionsByRole')->listBox($model->getPermissionsByRole(), [
                        'multiple' => 'true',
                        'size' => 8
                    ])->label(Module::t('module', 'Permissions by role')) ?>

                    <?= $form->field($model, 'name')->hiddenInput()->label(false) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-2">
                    <div class="text-center">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'form' => 'form-remove-permissions']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'form' => 'form-add-permissions']) ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-remove-permissions',
                        'action' => Url::to(['add-permissions'])
                    ]); ?>

                    <?= $form->field($model, 'itemsPermissions')->listBox($model->getItemsPermissions(), [
                        'multiple' => 'true',
                        'size' => 8
                    ]) ?>

                    <?= $form->field($model, 'name')->hiddenInput()->label(false) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
