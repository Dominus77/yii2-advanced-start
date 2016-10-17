<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\main\models\frontend\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\widgets\passfield\Passfield;

$this->title = Yii::t('app', 'NAV_SIGN_UP');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-default-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Please fill out the following fields to signup:'); ?></p>

    <div class="row">
        <div class="col-md-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= Passfield::widget([
                'form' => $form,
                'model' => $model,
                'attribute' => 'password',
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

            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
