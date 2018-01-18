<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\backend\User */
/* @var $uploadModel modules\users\models\UploadForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="users-backend-profile-update">
    <?php
    $model->scenario = $model::SCENARIO_AVATAR_UPDATE;
    $form = ActiveForm::begin([
        'action' => Url::to(['update-avatar', 'id' => $model->id]),
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-10',
            ],
        ],
    ]); ?>
    <?php if ($model->avatar) : ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?= Html::img($model->getAvatarPath(), [
                    'class' => 'profile-user-img img-responsive img-circle',
                    'style' => 'margin:0; width:auto',
                    'alt' => 'avatar_' . $model->username,
                ]); ?>
            </div>
        </div>
        <div class="checkbox icheck">
            <?= $form->field($model, 'isDel')->checkbox(['class' => 'iCheck']); ?>
        </div>

    <?php else : ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?= $model->getGravatar(null, 80, 'mm', 'g', true, [
                    'class' => 'profile-user-img img-responsive img-circle',
                    'style' => 'margin:0; width:auto',
                    'alt' => 'avatar_' . $model->username,
                ]); ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput(); ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Save'), [
                'class' => 'btn btn-primary',
                'name' => 'submit-button',
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
