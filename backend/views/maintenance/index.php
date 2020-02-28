<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\maintenance\models\FileStateForm;

/**
 * @var $this View
 * @var $name string
 * @var $model FileStateForm
 * @var $isEnable bool
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
";
$this->registerJs($script);

$this->title = $name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-index">
    <div class="box <?= $isEnable ? 'box-danger' : 'box-success' ?>">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->modeName) ?></h3>
            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <?php if ($followers = $model->followers) { ?>
                        <h3><?= Yii::t('app', 'Followers') ?></h3>
                        <?php foreach ($followers as $follower) {
                            echo $follower . '<br>';
                        } ?>
                    <?php } ?>
                </div>
            </div>
            <br>
            <br>
        </div>
        <div class="box-footer">
            <p class="pull-right">Maintenance</p>
        </div>
    </div>
</div>
