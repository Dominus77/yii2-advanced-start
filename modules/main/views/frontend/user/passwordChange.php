<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\components\widgets\passfield\Passfield;

/* @var $this yii\web\View */
/* @var $model \modules\main\models\frontend\PasswordChangeForm */

$this->title = Yii::t('app', 'PASSWORD_CHANGE');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'NAV_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="user-password-change">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-5">
            <?php $form = ActiveForm::begin(); ?>
            <div class="form-group">
                <?= $form->field($model, 'currentPassword')->passwordInput([
                    'maxlength' => true,
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group">
                <?= Passfield::widget([
                    'form' => $form,
                    'model' => $model,
                    'attribute' => 'newPassword',
                    'options' => [
                        'class' => 'form-control',
                    ],
                    'config' => [
                        'locale' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '_')),
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
                <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
                    'maxlength' => true,
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> ' . Yii::t('app', 'SAVE'), [
                    'class' => 'btn btn-primary',
                    'name' => 'change-button'
                ]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
