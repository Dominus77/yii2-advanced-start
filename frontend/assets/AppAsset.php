<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap\BootstrapAsset;
use common\assets\FontAwesomeAsset;
use common\assets\Html5ShivAsset;
use common\assets\RespondAsset;

/**
 * Class AppAsset
 * @package frontend\assets
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
     * @var array
     */
    public $css = [
        'css/site.css'
    ];

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        FontAwesomeAsset::class,
        Html5ShivAsset::class,
        RespondAsset::class
    ];
}
