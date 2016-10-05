<?php

namespace backend\assets\AdminLTE;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SkinsAsset extends AssetBundle
{
    public $sourcePath = '@adminlte/dist';
    public $css;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = ['css/skins/_all-skins' . $min . '.css'];
    }
    public $depends = [];
}
