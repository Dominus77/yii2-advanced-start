<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

        <div class="form-group">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
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
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => $model->statusesArray,
                'options' => [
                    'placeholder' => Yii::t('app', 'Select a status ...'),
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
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-plus"></span> ' . Yii::t('app', 'CREATE') : '<span class="fa fa-floppy-o"></span> ' . Yii::t('app', 'SAVE'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'name' => 'submit-button',
        ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
