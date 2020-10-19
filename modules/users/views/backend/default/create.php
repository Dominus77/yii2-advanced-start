<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 */

$this->title = Module::translate('module', 'Users');
$this->params['title']['small'] = Module::translate('module', 'Create');

$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::translate('module', 'Create');
?>

<div class="users-backend-default-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::translate('module', 'Create'); ?></h3>
        </div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body">

            <?= $form->field($model, 'username')->textInput([
                'maxlength' => true,
                'placeholder' => true,
            ]) ?>

            <?= $form->field($model, 'email')->textInput([
                'maxlength' => true,
                'placeholder' => true,
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'maxlength' => true,
                'placeholder' => true,
            ]) ?>

            <?= $form->field($model, 'status')->dropDownList($model->statusesArray) ?>


        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="fas fa-save"></span> ' . Module::translate(
                    'module',
                    'Create'
                ), [
                    'class' => 'btn btn-success',
                    'name' => 'submit-button',
                ]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
