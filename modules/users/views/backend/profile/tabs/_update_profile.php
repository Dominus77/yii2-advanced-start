<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-sm-6">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'first_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => true,
        ]) ?>

        <?= $form->field($model, 'last_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => true,
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Save'), [
                'class' => 'btn btn-primary',
                'name' => 'submit-button',
            ]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
