<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'UPDATE_DATA');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'NAV_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>

<div class="user-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-5">
            <?php $form = ActiveForm::begin(); ?>
            <div class="form-group">
                <?= $form->field($model, 'username')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                ]); ?>
                <?= $form->field($model, 'email')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'disabled' => true,
                ]); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> ' . Yii::t('app', 'SAVE'), [
                    'class' => 'btn btn-primary',
                    'name' => 'update-button',
                ]); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>