<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use backend\assets\BootstrapAsset;

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
        JqueryAsset::class,
        BootstrapAsset::class
    ];
}
