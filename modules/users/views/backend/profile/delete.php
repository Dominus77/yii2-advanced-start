<?php

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\UserDeleteForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

$this->title = Module::t('module', 'Confirm deleting profile');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-profile-delete">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->user->username); ?></h3>
        </div>

        <?php $form = ActiveForm::begin([
            'validationUrl' => ['ajax-validate-password-delete-form'],
        ]); ?>
        <div class="box-body">
            <?= $form->field($model, 'currentPassword', ['enableAjaxValidation' => true])->passwordInput([
                'maxlength' => true,
                'placeholder' => true,
            ]) ?>
        </div>
        <div class="box-footer">

            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-trash"></span> ' . Module::t('module', 'Delete'), [
                    'class' => 'btn btn-danger',
                    'name' => 'submit-button',
                ]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
