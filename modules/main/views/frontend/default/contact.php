<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use modules\main\Module;
use modules\main\models\frontend\ContactForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model ContactForm */

$this->title = Module::t('module', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-frontend-default-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Module::t('module', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.') ?>
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <?php if ($model->scenario === $model::SCENARIO_GUEST) : ?>
                <div class="form-group">
                    <?= $form->field($model, 'name')->textInput(['class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <?= $form->field($model, 'subject')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'body')->textarea(['rows' => 6, 'class' => 'form-control']) ?>
            </div>
            <?php if ($model->scenario === $model::SCENARIO_GUEST) : ?>
                <div class="form-group">
                    <?php try {
                        echo $form->field($model, 'verifyCode')->widget(Captcha::class, [
                            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                            'captchaAction' => Url::to('/main/default/captcha'),
                            'imageOptions' => [
                                'style' => 'display:block; border:none; cursor: pointer',
                                'alt' => Module::t('module', 'Code'),
                                'title' => Module::t('module', 'Click on the picture to change the code.')
                            ],
                            'class' => 'form-control'
                        ]);
                    } catch (Exception $e) {
                        // Save log
                    } ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-send"></span> ' . Module::t('module', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
