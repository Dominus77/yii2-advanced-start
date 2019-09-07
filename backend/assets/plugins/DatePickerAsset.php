<?php

namespace backend\assets\plugins;

use Yii;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use backend\assets\BootstrapAsset;

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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $language = self::$language ?: substr(Yii::$app->language, 0, 2);
        $this->css = [
            'dist/css/bootstrap-datepicker3.css'
        ];
        $this->js = [
            'dist/js/bootstrap-datepicker' . $min . '.js',
            'dist/locales/bootstrap-datepicker.' . $language . '.min.js'
        ];
    }

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class
    ];
}
