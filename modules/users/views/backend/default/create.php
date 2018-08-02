<?php

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

$this->title = Module::t('module', 'Users');
$this->params['title']['small'] = Module::t('module', 'Create');

$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Create');
?>

<div class="users-backend-default-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Create'); ?></h3>
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
                <?= Html::submitButton('<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Create'), [
                    'class' => 'btn btn-success',
                    'name' => 'submit-button',
                ]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
