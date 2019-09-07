<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use common\assets\Html5ShivAsset;
use common\assets\RespondAsset;
use common\assets\FontAwesomeAsset;
use common\assets\IonIconsAsset;
use backend\assets\plugins\SlimScrollAsset;
use backend\assets\plugins\FastClickAsset;

/**
 * Class AppAsset
 * @package backend\assets
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';

    /**
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->css[] = 'css/site.css';
        $this->js[] = 'js/dashboard.js';
    }

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        Html5ShivAsset::class,
        RespondAsset::class,
        FontAwesomeAsset::class,
        IonIconsAsset::class,
        SlimScrollAsset::class,
        FastClickAsset::class,
        AdminLteAsset::class
    ];
}
