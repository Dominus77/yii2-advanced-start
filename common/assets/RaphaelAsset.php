<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Class RaphaelAsset
 *
 * @package common\assets
 */
class RaphaelAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/raphael';

    /**
     * @inheritDoc
     */
    public function init()
    {
        $min = YII_ENV_DEV ? '' : '.min';
        $this->js = [
            'raphael' . $min . '.js'
        ];
        parent::init();
    }
}
