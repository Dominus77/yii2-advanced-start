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
<div class="users-frontend-profile-delete">

    <?php $form = ActiveForm::begin([
        'validationUrl' => ['ajax-validate-password-delete-form'],
    ]); ?>

    <?= $form->field($model, 'currentPassword', ['enableAjaxValidation' => true])->passwordInput([
        'maxlength' => true,
        'placeholder' => true,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-trash"></span> ' . Module::t('module', 'Delete'), [
            'class' => 'btn btn-danger',
            'name' => 'submit-button',
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
