<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class ColorPickerAsset
 * @package backend\assets\plugins
 */
class ColorPickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-colorpicker';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'dist/css/bootstrap-colorpicker' . $min . '.css',
        ];
        $this->js = [
            'dist/js/bootstrap-colorpicker' . $min . '.js',
        ];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
