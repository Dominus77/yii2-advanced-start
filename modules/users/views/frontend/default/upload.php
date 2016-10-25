<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\user\Module;

$this->title = Module::t('module', 'TITLE_PROFILE_UPLOAD');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TITLE_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TITLE_PROFILE_UPDATE'), 'url' => ['update']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-upload">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'imageFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Module::t('module', 'BUTTON_UPLOAD'), ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>