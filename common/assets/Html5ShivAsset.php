<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class Html5ShivAsset
 * @package common\assets
 */
class Html5ShivAsset extends AssetBundle
{
    public $sourcePath = '@bower/html5shiv/dist';
    public $js = [
        'html5shiv.min.js',
    ];
    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => View::POS_HEAD,
    ];
}

