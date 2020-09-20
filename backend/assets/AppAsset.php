<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\jui\JuiAsset;
use common\assets\Html5ShivAsset;
use common\assets\RespondAsset;
use common\assets\FontAwesomeAsset;
use common\assets\IonIconsAsset;
use backend\assets\plugins\SlimScrollAsset;
use backend\assets\plugins\FastClickAsset;
use backend\assets\plugins\KnobAsset;

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
        BootstrapFixAsset::class,
        JuiAsset::class,
        Html5ShivAsset::class,
        RespondAsset::class,
        FontAwesomeAsset::class,
        IonIconsAsset::class,
        SlimScrollAsset::class,
        FastClickAsset::class,
        KnobAsset::class,
        AdminLteAsset::class
    ];
}
