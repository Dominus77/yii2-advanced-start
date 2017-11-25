<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\frontend\User */
/* @var $uploadModel modules\users\models\UploadForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="users-frontend-default-update">
    <?php
    $form = ActiveForm::begin([
        'action' => Url::to(['update-avatar']),
    ]); ?>
    <?php if ($model->avatar) : ?>
        <div class="form-group">
            <?= Html::img($model->getAvatarPath(), [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'margin:0; width:auto',
                'alt' => 'avatar_' . $model->username,
            ]); ?>
        </div>

        <div class="checkbox icheck">
            <?= $form->field($model, 'isDel')->checkbox(['class' => 'iCheck']); ?>
        </div>

    <?php else : ?>
        <div class="form-group">
            <?= $model->getGravatar(null, 80, 'mm', 'g', true, [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'margin:0; width:auto',
                'alt' => 'avatar_' . $model->username,
            ]); ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput(); ?>

    <div class="form-group">

        <?= Html::submitButton('<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Save'), [
            'class' => 'btn btn-primary',
            'name' => 'submit-button',
        ]) ?>

    </div>

    <?php ActiveForm::end(); ?>
</div>
