<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\main\models\frontend\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use modules\main\Module;

$this->title = Module::t('frontend', 'TITLE_CONTACT');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-default-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Module::t('frontend', 'TEXT_CONTACT'); ?>
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="form-group">
                <?= $form->field($model, 'name')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'subject')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'body')->textarea(['rows' => 6, 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    'captchaAction' => Url::to(['/main/default/captcha']),
                    'imageOptions' => [
                        'style' => 'display:block; border:none; cursor: pointer',
                        'alt' => Module::t('frontend', 'CAPTCHA_IMAGE_ALT'),
                        'title' => Module::t('frontend', 'CAPTCHA_IMAGE_TITLE'),
                    ],
                    'class' => 'form-control',
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-send"></span> ' . Module::t('frontend', 'BUTTON_SUBMIT'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
