<?php

namespace backend\widgets\chart\chartjs\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use backend\assets\BootstrapAsset;

/**
 * Class ChartJsAsset
 *
 * @package backend\widgets\chart\chartjs\assets
 */
class ChartJsAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/chart.js';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->js = [
            'Chart.js'
        ];
    }

    /**
     * @var string[]
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class
    ];
}
