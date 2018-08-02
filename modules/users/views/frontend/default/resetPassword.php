<?php

/**
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model \modules\users\models\ResetPasswordForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\widgets\passfield\Passfield;
use modules\users\models\User;
use modules\users\Module;

$this->title = Module::t('module', 'Reset Password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-frontend-default-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('module', 'Create a new password') ?></p>

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
                        'placeholder' => true,
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
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> ' . Module::t('module', 'Save'), [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
