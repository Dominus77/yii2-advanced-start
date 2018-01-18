<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class SlimScrollAsset
 * @package backend\assets\plugins
 */
class SlimScrollAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/jquery-slimscroll';

    /**
     * @var array
     */
    public $js = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->js = ['jquery.slimscroll' . $min . '.js'];
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
