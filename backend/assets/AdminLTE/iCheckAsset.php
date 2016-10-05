<?php

namespace backend\assets\AdminLTE;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class iCheckAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/AdminLTE/plugins/iCheck';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'square/blue.css'
        ];
        $this->js = [
            'icheck' . $min . '.js',
            'script.js'
        ];
    }
}
