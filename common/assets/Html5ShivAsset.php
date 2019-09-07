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
    /**
     * @var string
     */
    public $sourcePath = '@bower/html5shiv/dist';

    /**
     * @var array
     */
    public $js = [
        'html5shiv.min.js'
    ];

    /**
     * @var array
     */
    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => View::POS_HEAD
    ];
}
