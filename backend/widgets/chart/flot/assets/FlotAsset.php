<?php

namespace backend\widgets\chart\flot\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class FlotAsset
 *
 * @package backend\widgets\chart\flot\assets
 */
class FlotAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/Flot';

    /** @var string[] */
    public $js = [
        'jquery.flot.js',
        'jquery.flot.resize.js',
        'jquery.flot.pie.js',
        'jquery.flot.categories.js'
    ];

    /**
     * @var string[]
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
