<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class FastClickAsset
 * @package backend\assets\plugins
 */
class FastClickAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/fastclick/lib';

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
        $this->js = ['fastclick.js'];
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
