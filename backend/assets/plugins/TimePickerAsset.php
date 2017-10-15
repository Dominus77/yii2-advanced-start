<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class TimePickerAsset
 * @package backend\assets\plugins
 */
class TimePickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-timepicker';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $this->css = [
            'css/timepicker.less',
        ];
        $this->js = [
            'js/bootstrap-timepicker.js',
        ];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
