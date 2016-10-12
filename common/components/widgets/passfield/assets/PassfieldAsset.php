<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 12.10.16
 * Time: 8:28
 */

namespace common\components\widgets\passfield\assets;

use yii\web\AssetBundle;
use yii\web\View;

class PassfieldAsset extends AssetBundle
{
    public $sourcePath = '@common/components/widgets/passfield/assets/src';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
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

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesomeAsset',
        'common\assets\IonIconsAsset',
    ];
}