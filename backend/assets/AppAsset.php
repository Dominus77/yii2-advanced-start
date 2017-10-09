<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package backend\assets
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
        'common\assets\FontAwesomeAsset',
        'common\assets\IonIconsAsset',
        'backend\assets\AdminLteAsset',
        'backend\assets\AdminLTE\iCheckAsset',
        'common\assets\Html5ShivAsset',
        'common\assets\RespondAsset'
    ];
}
