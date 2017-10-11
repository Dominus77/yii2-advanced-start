<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
                //'multiple' => 'true',
                'size' => 8
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' . Yii::t('app', 'CREATE') : '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . Yii::t('app', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
