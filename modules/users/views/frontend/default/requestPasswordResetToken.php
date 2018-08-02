<?php

/**
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model \modules\users\models\PasswordResetRequestForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

$this->title = Module::t('module', 'Password Reset Form');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-frontend-default-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('module', 'Enter your email address'); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput([
                'placeholder' => true,
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-send"></span> ' . Module::t('module', 'Send'), [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
