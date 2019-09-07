<?php

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class PngFixAsset
 * @package common\assets
 */
class PngFixAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src/pngfix';
        $this->js = [
            'jquery.ifixpng.js',
            'script.js'
        ];
    }

    /**
     * @var array
     */
    public $jsOptions = [
        'condition' => 'lt IE 7',
        'position' => View::POS_HEAD
    ];
}
