<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Permission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rbac-permissions-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-permission',
        'enableAjaxValidation' => true,
        'validationUrl' => ['ajax-validate-form']
    ]); ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'disabled' => $model->scenario === $model::SCENARIO_UPDATE
    ])->hint(Module::t('module', 'Example: updatePost')) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

    <?php if ($model->scenario === $model::SCENARIO_UPDATE) : ?>
        <div id="assign-container-permissions">
            <div class="row">
                <div class="col-md-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-add-permissions',
                        'action' => Url::to(['remove-permissions'])
                    ]); ?>

                    <?= $form->field($model, 'permissions')->listBox($model->getPermissionChildren(), [
                        'multiple' => 'true',
                        'size' => 8
                    ])->label(Module::t('module', 'Permissions by role')) ?>

                    <?= $form->field($model, 'name')->hiddenInput()->label(false) ?>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-2">
                    <div class="text-center">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'form' => 'form-items-permission']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>', ['class' => 'btn btn-default', 'form' => 'form-add-permissions']) ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-items-permission',
                        'action' => Url::to(['add-permissions'])
                    ]); ?>

                    <?= $form->field($model, 'permissionItems')->listBox($model->getItemsPermissions(), [
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
