<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rbac-backend-assign-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'role')->listBox($model->rolesArray, [
                'size' => 8
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' . Module::t('module', 'Create') : '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' . Module::t('module', 'Save'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
