<?php

namespace backend\widgets\map\jvector\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class JVectorMapAsset
 *
 * @package backend\widgets\map\jvector\assets
 */
class JVectorMapAsset extends AssetBundle
{
    /** @var string */
    public $version = '2.0.5';
    /** @var string */
    public $sourcePath = __DIR__ . '/src/dist';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->css = [
            'jquery-jvectormap-' . $this->version . '.css'
        ];
        $this->js = [
            'jquery-jvectormap-' . $this->version . '.min.js'
        ];
    }

    /**
     * @var string[]
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
