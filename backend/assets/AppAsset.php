<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package backend\assets
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];
    public $js = [];

    public function init()
    {
        parent::init();
        $this->css[] = 'css/site.css';
        $this->js[] = 'js/dashboard.js';
    }

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\BootstrapAsset',
        'common\assets\Html5ShivAsset',
        'common\assets\RespondAsset',
        'common\assets\FontAwesomeAsset',
        'common\assets\IonIconsAsset',
        'backend\assets\plugins\SlimScrollAsset',
        'backend\assets\plugins\FastClickAsset',
        'backend\assets\AdminLteAsset',
    ];
}
