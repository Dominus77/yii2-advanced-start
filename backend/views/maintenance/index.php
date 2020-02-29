<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\maintenance\models\FileStateForm;
use common\widgets\timer\CountDown;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;

/**
 * @var $this View
 * @var $name string
 * @var $model FileStateForm
 * @var $isEnable bool
 * @var $listDataProvider ArrayDataProvider
 */

$modeOn = FileStateForm::MODE_MAINTENANCE_ON;
$modeOff = FileStateForm::MODE_MAINTENANCE_OFF;
$script = "
    let maintenance = $('#filestateform-mode'),
        settings = $('#maintenance-setting-container'),
        on = '{$modeOn}',
        off = '{$modeOff}';

    function toggleSettings(mode)
    {
        if(mode === off) {            
            settings.hide('slow');
        }        
        if(mode === on) {            
            settings.show('slow');
        }
    }
    
    toggleSettings(maintenance.val());
    
    maintenance.on('change', function(){
        toggleSettings(this.value);
    });
    
    setTimeout(function(){
        $('.alert').fadeOut(2000,'swing');
    }, 3000);
";
$this->registerJs($script);
$cssStyle = '
    #list-followers .summary {
        margin-bottom: 15px;
    }
';
$this->registerCss($cssStyle);

$this->title = $name;
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="maintenance-index">
    <div class="row">
        <div class="col-md-6">
            <div class="box <?= $isEnable ? 'box-danger' : 'box-success' ?>">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($model->modeName) ?> <?= $isEnable ? Yii::t('app', 'up {:date}', [':date' => $model->datetime]) : '' ?></h3>
                    <div class="box-tools pull-right"></div>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'maintenance-update-form',
                        'action' => Url::to(['/maintenance/index']),
                    ]); ?>
                    <?= $form->field($model, 'mode')->dropDownList($model::getModesArray()) ?>

                    <div style="display:none" id="maintenance-setting-container">
                        <?= $form->field($model, 'date')->textInput([
                            'placeholder' => date($model->dateFormat),
                        ]) ?>

                        <?= $form->field($model, 'title')->textInput([
                            'placeholder' => true,
                        ]) ?>

                        <?= $form->field($model, 'text')->textarea([
                            'placeholder' => true,
                            'rows' => 6,
                            'class' => 'form-control'
                        ]) ?>

                        <?= $form->field($model, 'subscribe')->checkbox() ?>
                    </div>

                    <?= Html::submitButton(Yii::t('app', 'Save'), [
                        'class' => 'btn btn-primary',
                        'name' => 'maintenance-subscribe-button'
                    ]) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="box-footer">
                    <div class="pull-left">
                        <?= CountDown::widget([
                            'status' => $isEnable,
                            'timestamp' => $model->timestamp,
                            'message' => Yii::t('app', 'Time is over'),
                            'countContainerOptions' => [
                                'style' => 'display:none;'
                            ],
                            'noteContainerOptions' => [
                                'style' => 'text-align: left;',
                            ]
                        ]) ?>
                    </div>
                    <div class="pull-right">
                        <?php if ($message = Yii::$app->session->getFlash($model::MAINTENANCE_UPDATE_KEY)) { ?>
                            <p class="alert" style="color: green"><?= $message ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Followers') ?></h3>
                    <div class="box-tools pull-right"></div>
                </div>
                <div class="box-body">
                    <?= ListView::widget([
                        'dataProvider' => $listDataProvider,
                        'layout' => "{summary}\n{items}\n{pager}",
                        'options' => [
                            'tag' => 'div',
                            'class' => 'list-wrapper',
                            'id' => 'list-followers',
                        ],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return Html::a($key, 'mailto:' . $key);
                        }
                    ]) ?>
                </div>
                <div class="box-footer">
                    <div class="pull-left">
                        <?php if ($message = Yii::$app->session->getFlash($model::MAINTENANCE_NOTIFY_SENDER_KEY)) { ?>
                            <p class="alert" style="color: green"><?= $message ?>.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
