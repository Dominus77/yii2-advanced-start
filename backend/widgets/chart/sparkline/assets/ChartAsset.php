<?php

namespace backend\widgets\chart\sparkline\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class ChartAsset
 *
 * @package backend\widgets\chart\sparkline\assets
 */
class ChartAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/jquery-sparkline/dist';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->js = [
            'jquery.sparkline' . $min . '.js'
        ];
    }

    /**
     * @var string[]
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
