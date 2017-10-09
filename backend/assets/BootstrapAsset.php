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
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist';

    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = ['css/bootstrap' . $min . '.css'];
        $this->js = ['js/bootstrap' . $min . '.js'];

        // Подключаем свои файлы Bootstrap
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
                'sourcePath' => $this->sourcePath,
                'css' => [$this->css],
        ];
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = [
            'sourcePath' => $this->sourcePath,
            'js' => [$this->js],
        ];
    }

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
