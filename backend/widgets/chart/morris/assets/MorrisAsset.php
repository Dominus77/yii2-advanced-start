<?php

namespace backend\widgets\chart\morris\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use backend\assets\RaphaelAsset;

/**
 * Class MorrisAsset
 *
 * @package backend\widgets\chart\morris\assets
 */
class MorrisAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/morris.js';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'morris.css'
        ];
        $this->js = [
            'morris' . $min . '.js'
        ];
    }

    /**
     * @var string[]
     */
    public $depends = [
        JqueryAsset::class,
        RaphaelAsset::class
    ];
}
