<?php

namespace frontend\widgets\timer\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class CountDownAsset
 * @package frontend\widgets\timer\assets
 */
class CountDownAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';

        $this->css = [
            'http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300',
            'css/styles.css',
            'css/jquery.countdown.css'
        ];

        $this->js = [
            'js/jquery.countdown.js',
        ];

        $this->publishOptions = [
            'forceCopy' => YII_ENV_DEV ? true : false
        ];
    }

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
    ];
}
