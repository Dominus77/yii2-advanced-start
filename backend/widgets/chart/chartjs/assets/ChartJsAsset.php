<?php

namespace backend\widgets\chart\chartjs\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class ChartJsAsset
 *
 * @package backend\widgets\chart\chartjs\assets
 */
class ChartJsAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@bower/chart.js/dist';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'Chart' . $min . '.css'
        ];
        $this->js = [
            'Chart' . $min . '.js'
        ];
    }

    /**
     * @var string[]
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
