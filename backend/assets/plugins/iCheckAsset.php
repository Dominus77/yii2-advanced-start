<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class iCheckAsset
 * @package backend\assets\plugins
 */
class iCheckAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'iCheck/all.css',
        ];
        $this->js = ['iCheck/icheck' . $min . '.js'];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
