<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class FastClickAsset
 * @package backend\assets\plugins
 */
class FastClickAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/fastclick/lib';
    public $js;

    public function init()
    {
        parent::init();
        $this->js = ['fastclick.js'];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
