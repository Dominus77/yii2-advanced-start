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

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->js = [
            'excanvas' . $min . '.js',
            'jquery.flot.js',
            'jquery.flot.pie.js',
            'jquery.flot.categories.js',
            'jquery.flot.resize.js'
        ];
    }

    /**
     * @var string[]
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
