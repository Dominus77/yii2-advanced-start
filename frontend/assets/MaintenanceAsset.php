<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap\BootstrapPluginAsset;
use common\assets\FontAwesomeAsset;
use common\assets\Html5ShivAsset;
use common\assets\RespondAsset;

/**
 * Class MaintenanceAsset
 * @package frontend\assets
 */
class MaintenanceAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/maintenance';

        $this->css = [
            'css/maintenance.css',
        ];

        $this->publishOptions = [
            'forceCopy' => YII_ENV_DEV ? true : false
        ];
    }

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        BootstrapPluginAsset::class,
        FontAwesomeAsset::class,
        Html5ShivAsset::class,
        RespondAsset::class
    ];
}
