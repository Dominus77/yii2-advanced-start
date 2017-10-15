<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class DateRangePickerAsset
 * @package backend\assets\plugins
 */
class DateRangePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $this->css = [
            'bootstrap-daterangepicker/daterangepicker.css',
        ];
        $this->js = [
            'bootstrap-daterangepicker/daterangepicker.js',
        ];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
