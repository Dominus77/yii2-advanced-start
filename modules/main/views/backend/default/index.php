<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Home');
?>
<div class="main-backend-default-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="<?= Yii::t('app', 'Collapse'); ?>">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="<?= Yii::t('app', 'Remove'); ?>">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">

        </div>
        <div class="box-footer">

        </div>
    </div>
</div>
