<?php

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $form yii\widgets\ActiveForm
 */

use yii\helpers\Html;
use yii\helpers\Url;
use modules\users\widgets\AvatarWidget;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

?>

<div class="row">
    <div class="col-sm-12">
        <p>
            <?= Module::t('module', 'To change the avatar, please use the {:link} service.', [
                ':link' => Html::a('Gravatar', 'http://www.gravatar.com', [
                    'target' => '_blank'
                ])
            ]) ?>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-sm-2">
        <?= AvatarWidget::widget([
            'size' => 150,
            'imageOptions' => [
                'class' => 'img-thumbnail'
            ]
        ]) ?>
    </div>
    <div class="col-sm-5">
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['update-avatar']),
            'validationUrl' => ['ajax-validate-avatar-form'],
        ]); ?>

        <?= $form->field($model->profile, 'email_gravatar', ['enableAjaxValidation' => true])->textInput([
            'maxlength' => true,
            'placeholder' => true,
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Save'), [
                'class' => 'btn btn-primary',
                'name' => 'submit-button',
            ]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
