<?php

namespace backend\assets\AdminLTE;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/AdminLTE/dist';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = ['css/AdminLTE' . $min . '.css'];
        $this->js = ['js/app' . $min . '.js'];
    }
    public $depends = [];
}
