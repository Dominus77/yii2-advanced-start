<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class DateRangePickerAsset
 * @package backend\assets\plugins
 */
class DateRangePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-daterangepicker';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $this->css = [
            'daterangepicker.css',
        ];
        $this->js = [
            'daterangepicker.js',
        ];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
