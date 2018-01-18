<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class DateRangePickerAsset
 * @package backend\assets\plugins
 */
class DateRangePickerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/bootstrap-daterangepicker';

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
        $this->css = [
            'daterangepicker.css',
        ];
        $this->js = [
            'daterangepicker.js',
        ];
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
