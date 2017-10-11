<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\components\widgets\passfield\Passfield;
use modules\users\models\backend\User;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\backend\User */
/* @var $uploadModel modules\users\models\UploadForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-backend-form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-10',
            ],
        ],
        'options' => [
            'enctype' => 'multipart/form-data',

        ]
    ]); ?>
    <div class="box-body">

        <?= $form->field($model, 'username')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            //'disabled' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_UPDATE_USERS) ? false : true,
            'placeholder' => Module::t('backend', 'USERNAME'),
        ]) ?>

        <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            //'disabled' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_UPDATE_USERS) ? false : true,
            'placeholder' => Module::t('backend', 'EMAIL'),
        ]) ?>

        <?= Passfield::widget([
            'form' => $form,
            'model' => $model,
            'attribute' => 'newPassword',
            'options' => [
                'maxlength' => true,
                'class' => 'form-control',
                'placeholder' => Module::t('backend', 'PASSWORD'),
            ],
            'config' => [
                'locale' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '-')),
                'showToggle' => true,
                'showGenerate' => true,
                'showWarn' => true,
                'showTip' => true,
                'length' => [
                    'min' => User::LENGTH_STRING_PASSWORD_MIN,
                    'max' => User::LENGTH_STRING_PASSWORD_MAX,
                ]
            ],
        ]); ?>

        <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('backend', 'USER_REPEAT_PASSWORD'),
        ]) ?>

        <?= $form->field($model, 'imageFile')->fileInput() ?>

        <?= $form->field($model, 'first_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('backend', 'FIRST_NAME'),
        ]) ?>

        <?= $form->field($model, 'last_name')->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => Module::t('backend', 'LAST_NAME'),
        ]) ?>

        <?= $form->field($model, 'role')->dropDownList($model->rolesArray, [
            'class' => 'form-control',
            'disabled' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_RBAC) ? false : true,
        ]) ?>

        <?= $form->field($model, 'status')->dropDownList($model->statusesArray, [
            'class' => 'form-control',
            //'disabled' => Yii::$app->user->can(\modules\rbac\models\Role::ROLE_ADMIN) ? false : true,
        ]) ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-plus"></span> ' . Module::t('backend', 'BUTTON_CREATE') : '<span class="fa fa-floppy-o"></span> ' . Module::t('backend', 'BUTTON_SAVE'), [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'name' => 'submit-button',
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
