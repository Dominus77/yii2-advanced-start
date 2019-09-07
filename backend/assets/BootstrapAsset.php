<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;
use yii\bootstrap\BootstrapAsset as YiiBootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset as YiiBootstrapPluginAsset;
use yii\web\YiiAsset;

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
        $assetManager->bundles[YiiBootstrapAsset::class] = [
            'sourcePath' => $this->sourcePath,
            'css' => [$this->css]
        ];
        $assetManager->bundles[YiiBootstrapPluginAsset::class] = [
            'sourcePath' => $this->sourcePath,
            'js' => [$this->js]
        ];
    }

    public $depends = [
        YiiAsset::class
    ];
}
