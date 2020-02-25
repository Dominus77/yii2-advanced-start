<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\maintenance\models\Manager;
use yii\helpers\VarDumper;

/**
 * @var $this View
 * @var $name string
 * @var $model Manager
 */

$this->title = $name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin([
                        'id' => 'maintenance-update-form',
                        'action' => Url::to(['/maintenance/index']),
                        'fieldConfig' => [
                            'template' => "<div class=\"input-group\"><div class=\"input-group-addon\"><span class=\"fa fa-calendar\"></span></div>{input}</div>\n{hint}\n{error}",
                        ],
                    ]); ?>
                    <?= $form->field($model, 'date')->textInput([
                        'placeholder' => true,
                    ])->label(false) ?>

                    <?= Html::submitButton(Yii::t('app', 'Save'), [
                        'class' => 'btn btn-primary',
                        'name' => 'maintenance-subscribe-button'
                    ]) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <br>
            <br>
        </div>
        <div class="box-footer">
            <?php VarDumper::dump($model->isEnabled(), 10, 1); ?>
        </div>
    </div>
</div>
