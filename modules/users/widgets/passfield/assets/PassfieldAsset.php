<?php

namespace modules\users\widgets\passfield\assets;

use yii\web\AssetBundle;

/**
 * Class PassfieldAsset
 * @package modules\users\widgets\passfield\assets
 */
class PassfieldAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath;

    /**
     * @var array
     */
    public $css = [];

    /**
     * @var array
     */
    public $js = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'css/passfield' . $min . '.css'
        ];
        $this->js = YII_ENV_DEV ? [
            'js/passfield.js',
            'js/locales.js',
        ] : [
            'js/passfield' . $min . '.js',
        ];
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesomeAsset',
        'common\assets\IonIconsAsset',
    ];
}
