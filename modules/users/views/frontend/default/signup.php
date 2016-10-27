<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\users\models\frontend\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\models\frontend\User;
use modules\users\components\widgets\passfield\Passfield;
use modules\users\Module;

$this->title = Module::t('frontend', 'TITLE_SIGN_UP');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-default-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('frontend', 'TEXT_FOLLOWING_FIELDS_SIGN_UP'); ?></p>

    <div class="row">
        <div class="col-md-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="form-group">
                <?= $form->field($model, 'username')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= Passfield::widget([
                    'form' => $form,
                    'model' => $model,
                    'attribute' => 'password',
                    'options' => [
                        'class' => 'form-control',
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
            </div>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> ' . Module::t('frontend', 'BUTTON_SIGN_UP'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
