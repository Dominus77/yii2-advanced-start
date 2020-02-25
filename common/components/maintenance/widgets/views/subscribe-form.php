<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\maintenance\models\SubscribeForm;

/** @var $this View */
/** @var $model  SubscribeForm */
?>

<?php $form = ActiveForm::begin([
    'id' => 'maintenance-subscribe-form',
    'action' => Url::to(['/maintenance/subscribe']),
    'options' => [
        'class' => 'form-inline'
    ],
    'fieldConfig' => [
        'template' => "<div class=\"input-group\"><div class=\"input-group-addon\">@</div>{input}</div>\n{hint}\n{error}",
    ],
]); ?>

<?= $form->field($model, 'email')->textInput([
    'placeholder' => true,
])->label(false) ?>

<?= Html::submitButton(Yii::t('app', 'Notify me'), [
    'class' => 'btn btn-primary',
    'name' => 'maintenance-subscribe-button'
]) ?>
<?php ActiveForm::end(); ?>

<?php if ($alert = Yii::$app->session->getFlash('SUBSCRIBE_SUCCESS')) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <?= $alert ?>
    </div>
<?php } ?>
<?php if ($alert = Yii::$app->session->getFlash('SUBSCRIBE_INFO')) { ?>
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <?= $alert ?>
    </div>
<?php } ?>
