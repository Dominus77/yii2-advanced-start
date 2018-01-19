<?php

use yii\widgets\ActiveForm;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */

$script = "
    function submitForm(){
        var form = $('#pageSize_form');
        form.submit();
    };
";
$this->registerJs($script, yii\web\View::POS_BEGIN);
?>

<div class="users-backend-pageSize">
    <?php $form = ActiveForm::begin([
        'id' => 'pageSize_form',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true]
    ]); ?>
    <div class="form-group">
        <?= $form->field($model, 'pageSize')->dropDownList([
            10 => 10,
            25 => 25,
            50 => 50,
            100 => 100
        ], [
            'class' => 'form-control',
            'prompt' => Module::t('module', '- all -'),
            'onchange' => 'submitForm()',
        ])->label(false) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
