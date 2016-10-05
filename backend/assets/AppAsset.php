<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'backend\assets\FontAwesomeAsset',
        'backend\assets\IonIconsAsset',
        'backend\assets\AdminLTE\AdminLteAsset',
        //'backend\assets\AdminLTE\iCheckAsset',

        'backend\assets\Html5ShivAsset',
        'backend\assets\RespondAsset'
    ];
}
