<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 */

$this->title = Module::translate('module', 'Update');
$this->params['title']['small'] = $model->username;

$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::translate('module', 'Update');
?>

<div class="users-backend-default-update">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->username); ?></h3>
        </div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'username')->textInput([
                        'maxlength' => true,
                        'placeholder' => true,
                    ]) ?>

                    <?= $form->field($model, 'email')->textInput([
                        'maxlength' => true,
                        'placeholder' => true,
                    ]) ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'maxlength' => true,
                        'placeholder' => true,
                    ]) ?>

                    <?= $form->field($model, 'status')->dropDownList($model->statusesArray) ?>

                    <hr>

                    <?= $form->field($model->profile, 'first_name')->textInput([
                        'maxlength' => true,
                        'placeholder' => true,
                    ]) ?>

                    <?= $form->field($model->profile, 'last_name')->textInput([
                        'maxlength' => true,
                        'placeholder' => true,
                    ]) ?>

                    <?= $form->field($model->profile, 'email_gravatar')->textInput([
                        'maxlength' => true,
                        'placeholder' => true,
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="fas fa-save"></span> ' . Module::translate('module', 'Save'), [
                    'class' => 'btn btn-primary',
                    'name' => 'submit-button',
                ]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
