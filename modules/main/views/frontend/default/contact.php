<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\main\models\frontend\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'NAV_CONTACT');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-default-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.'); ?>
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    'captchaAction' => Url::to(['/main/default/captcha']),
                    'imageOptions' => [
                        'style' => 'display:block; border:none; cursor: pointer',
                        'alt' => Yii::t('app', 'CAPTCHA_IMAGE_ALT'),
                        'title' => Yii::t('app', 'CAPTCHA_IMAGE_TITLE'),
                    ],
                    'class' => 'form-control',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-send"></span> '.Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
