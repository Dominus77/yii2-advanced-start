<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class RaphaelAsset
 *
 * @package backend\assets
 */
class RaphaelAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/raphael';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->js = [
            'raphael' . $min . '.js'
        ];
    }
}
