<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class BootstrapFixAsset
 * @package backend\assets
 */
class BootstrapFixAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/src';

    public $js = [
        'js/fixtooltip.js'
    ];

    public $depends = [
        BootstrapAsset::class
    ];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];
}
