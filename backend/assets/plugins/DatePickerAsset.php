<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class DatePickerAsset
 * @package backend\assets\plugins
 */
class DatePickerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public static $language;

    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-datepicker';

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
        $language = self::$language ? self::$language : substr(\Yii::$app->language, 0, 2);
        $this->css = [
            'dist/css/bootstrap-datepicker3.css',
        ];
        $this->js = [
            'dist/js/bootstrap-datepicker' . $min . '.js',
            'dist/locales/bootstrap-datepicker.' . $language . '.min.js',
        ];
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        //'yii\jui\JuiAsset',
        'backend\assets\BootstrapAsset',
    ];
}
