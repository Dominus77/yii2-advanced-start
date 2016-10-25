<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use modules\users\Module;

$this->title = Module::t('backend', 'TITLE_UPLOAD');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_UPDATE'), 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-upload">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="users-backend-upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'imageFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Module::t('backend', 'BUTTON_UPLOAD'), ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>