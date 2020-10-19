<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use dominus77\jcrop\JCrop;
use modules\users\widgets\AvatarWidget;
use modules\users\widgets\UploadAvatarForm;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $uploadFormModel modules\users\models\UploadForm
 * @var $form yii\widgets\ActiveForm
 */

if (Yii::$app->request->get('modal') === 'show') {
    $script = "
       $('#modal-image').modal('show');
    ";
    $this->registerJs($script);
}
?>

<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
            <?= AvatarWidget::widget([
                'size' => 150,
                'user_id' => $model->id,
                'imageOptions' => [
                    'class' => 'img-thumbnail'
                ]
            ]) ?>
        </div>
        <?php if ($uploadFormModel->isThumbFile($model->id)) { ?>
            <div class="form-group">
                <?= Html::button(
                    '<span class="fa fa-pencil"></span> '
                    . Module::translate('module', 'Update'),
                    [
                        'class' => 'btn btn-sm btn-default',
                        'title' => Module::translate('module', 'Update'),
                        'data' => [
                            'toggle' => 'modal',
                            'target' => '#modal-image'
                        ]
                    ]
                ) ?>
                <?= Html::a(
                    '<span class="fa fa-trash"></span> ',
                    [
                        'delete-avatar',
                        'id' => $model->id
                    ],
                    [
                        'class' => 'btn btn-sm btn-danger',
                        'title' => Module::translate('module', 'Delete'),
                        'data' => [
                            'method' => 'post',
                            'confirm' => Module::translate(
                                'module',
                                'Are you sure you want to delete the avatar?'
                            )
                        ]
                    ]
                ) ?>
            </div>
        <?php } ?>
    </div>
    <div class="col-sm-5">
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['update-avatar']),
            'validationUrl' => ['ajax-validate-avatar-form'],
        ]); ?>

        <?= $form->field($model->profile, 'email_gravatar', ['enableAjaxValidation' => true])->textInput([
            'maxlength' => true,
            'placeholder' => true,
        ])->hint(Module::translate('module', 'To change the avatar, please use the {:link} service.', [
            ':link' => Html::a('Gravatar', 'http://www.gravatar.com', [
                'target' => '_blank'
            ])
        ])) ?>

        <div class="form-group">
            <?= Html::submitButton(
                '<span class="fas fa-save"></span> ' . Module::translate('module', 'Save'),
                [
                    'class' => 'btn btn-primary',
                    'name' => 'submit-button',
                ]
            ) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <hr>
        <?= UploadAvatarForm::widget() ?>
    </div>
</div>

<?php
Modal::begin(
    [
        'id' => 'modal-image',
        'header' => Html::tag(
            'span',
            '',
            [
                    'class' => 'fa fa-pencil'
                ]
        ) . ' ' . Module::translate('module', 'Update'),
        'footer' => Html::submitButton(
            '<span class="fas fa-save"></span> ' . Module::translate(
                'module',
                'Save'
            ),
            [
                'form' => 'crop-avatar-form',
                'class' => 'btn btn-primary',
                'name' => 'submit-button',
            ]
        )
    ]
); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'crop-avatar-form',
                'action' => Url::to(['crop-avatar']),
            ]) ?>
            <div class="form-group">
                <?= JCrop::widget([
                    'image' => Url::to(
                        [
                            '/users/profile/avatar',
                            'filename' => $uploadFormModel::PREFIX_THUMBNAIL . $uploadFormModel->getFileName()
                        ]
                    ),
                    'pluginOptions' => [
                        'minSize' => [150, 150],
                        'maxSize' => [540, 540],
                        'setSelect' => [10, 10, 280, 280],
                        'aspectRatio' => 1,
                        'bgColor' => 'black',
                        'bgOpacity' => 0.5,
                        'onSelect' => new JsExpression("
                            function(c){                                
                                $('#input-crop-width').val(c.w);
                                $('#input-crop-height').val(c.w);
                                $('#input-crop-x').val(c.x);
                                $('#input-crop-y').val(c.y);
                            }
                        "),
                        'onChange' => new JsExpression("
                            function(c){                               
                                $('#input-crop-width').val(c.w);
                                $('#input-crop-height').val(c.w);
                                $('#input-crop-x').val(c.x);
                                $('#input-crop-y').val(c.y);
                            }
                        ")
                    ],
                ]) ?>
            </div>

            <?= $form->field($uploadFormModel, 'cropWidth')->hiddenInput([
                'id' => 'input-crop-width',
            ])->label(false) ?>
            <?= $form->field($uploadFormModel, 'cropHeight')->hiddenInput([
                'id' => 'input-crop-height',
            ])->label(false) ?>
            <?= $form->field($uploadFormModel, 'cropX')->hiddenInput([
                'id' => 'input-crop-x',
            ])->label(false) ?>
            <?= $form->field($uploadFormModel, 'cropY')->hiddenInput([
                'id' => 'input-crop-y',
            ])->label(false) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
<?php Modal::end(); ?>
