<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\users\models\UploadForm;
use modules\users\Module;

/**
 * @var $model UploadForm
 */

?>

<?php $form = ActiveForm::begin([
    'action' => Url::to(['upload-image']),
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]) ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>

<?= Html::submitButton('<span class="fa fa-upload"></span> ' . Module::t('module', 'Submit'), [
    'class' => 'btn btn-primary',
    'name' => 'submit-button',
]) ?>
<?php ActiveForm::end() ?>
