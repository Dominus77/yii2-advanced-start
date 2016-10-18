<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\users\models\frontend\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\components\widgets\passfield\Passfield;
use modules\users\Module;

$this->title = Module::t('frontend', 'RESET_PASSWORD');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-default-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
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
                            'min' => $model::LENGTH_STRING_PASSWORD_MIN,
                            'max' => $model::LENGTH_STRING_PASSWORD_MAX,
                        ]
                    ],
                ]); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> ' . Module::t('frontend', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
