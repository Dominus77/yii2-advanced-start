<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\users\models\backend\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-backend-pageSize">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="form-group">
        <?= $form->field($model, 'pageSize')->dropDownList([
            10 => 10,
            25 => 25,
            50 => 50,
            100 => 100,
        ], [
            'class' => 'form-control',
            'onchange' => 'this.form.submit()',
        ])->label(false) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
