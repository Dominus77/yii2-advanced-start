<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class DatePickerAsset
 * @package backend\assets\plugins
 */
class DatePickerAsset extends AssetBundle
{
    public static $language;

    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $language = self::$language ? self::$language : substr(\Yii::$app->language, 0, 2);
        $this->css = [
            'bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
        ];
        $this->js = [
            'bootstrap-datepicker/dist/js/bootstrap-datepicker' . $min . '.js',
            'bootstrap-datepicker/dist/locales/bootstrap-datepicker.' . $language . '.min.js',
        ];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'backend\assets\BootstrapAsset',
    ];
}
