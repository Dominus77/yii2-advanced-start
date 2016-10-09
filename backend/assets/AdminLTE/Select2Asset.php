<?php

namespace backend\assets\AdminLTE;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@adminlte/plugins/select2';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'select2' . $min . '.css'
        ];
        $this->js = [
            'select2.full' . $min . '.js',
            'script.js'
        ];
    }

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
