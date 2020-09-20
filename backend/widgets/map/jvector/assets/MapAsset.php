<?php

namespace backend\widgets\map\jvector\assets;

use yii\web\AssetBundle;

/**
 * Class Map
 *
 * @package backend\widgets\map\jvector\assets
 */
class MapAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = __DIR__ . '/src/maps';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->js = [
            'jquery-jvectormap-world-mill-en.js'
        ];
    }

    /**
     * @var string[]
     */
    public $depends = [
        JVectorMapAsset::class,
    ];
}
