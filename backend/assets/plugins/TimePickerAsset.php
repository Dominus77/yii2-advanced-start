<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class TimePickerAsset
 * @package backend\assets\plugins
 */
class TimePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $this->css = [
            'bootstrap-timepicker/css/timepicker.less',
        ];
        $this->js = [
            'bootstrap-timepicker/js/bootstrap-timepicker.js',
        ];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
