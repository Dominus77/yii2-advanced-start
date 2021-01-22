<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */

use yii\helpers\Html;

$script = "
$('#generator-indexwidgettype').on('change', function(){
    if($(this).val() === 'list') {
        $('#pageSizeCheckbox').hide();
    } else {
        $('#pageSizeCheckbox').show();
    }
});
";
$this->registerJs($script);

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo Html::beginTag('div', ['id' => 'pageSizeCheckbox']);
echo $form->field($generator, 'enablePageSize')->checkbox();
echo Html::endTag('div');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
echo $form->field($generator, 'messageCategory');
