<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class RespondAsset
 * @package common\assets
 */
class RespondAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/respond/dest';

    /**
     * @var array
     */
    public $js = [
        'respond.min.js'
    ];

    /**
     * @var array
     */
    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => View::POS_HEAD
    ];
}
