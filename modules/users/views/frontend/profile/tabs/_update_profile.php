<?php

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $form yii\widgets\ActiveForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

?>

<div class="row">
    <div class="col-sm-6">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'first_name')->textInput([
            'maxlength' => true,
            'placeholder' => true,
        ]) ?>

        <?= $form->field($model, 'last_name')->textInput([
            'maxlength' => true,
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
