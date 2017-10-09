<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class SlimScrollAsset
 * @package backend\assets\plugins
 */
class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/jquery-slimscroll';
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->js = ['jquery.slimscroll' . $min . '.js'];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
