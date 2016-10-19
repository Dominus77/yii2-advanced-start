<?php

use yii\helpers\Html;
use modules\main\Module;

/* @var $this yii\web\View */

$this->title = Module::t('backend', 'TITLE_HOME');
?>
<div class="main-backend-default-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="<?= Module::t('backend', 'BUTTON_COLLAPSE'); ?>">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="<?= Module::t('backend', 'BUTTON_REMOVE'); ?>">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">

        </div>
        <div class="box-footer">

        </div>
    </div>
</div>
