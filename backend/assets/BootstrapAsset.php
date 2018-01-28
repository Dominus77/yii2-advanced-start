<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Class BootstrapAsset
 * @package backend\assets
 */
class BootstrapAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist';

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
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = ['css/bootstrap' . $min . '.css'];
        $this->js = ['js/bootstrap' . $min . '.js'];

        // Подключаем свои файлы Bootstrap
        $assetManager = Yii::$app->assetManager;
        $assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
            'sourcePath' => $this->sourcePath,
            'css' => [$this->css],
        ];
        $assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
            'sourcePath' => $this->sourcePath,
            'js' => [$this->js],
        ];
    }

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
