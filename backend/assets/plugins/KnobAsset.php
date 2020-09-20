<?php

namespace backend\assets\plugins;

use yii\web\JqueryAsset;
use yii\web\AssetBundle;

/**
 * Class KnobAsset
 *
 * @package backend\assets\plugins
 */
class KnobAsset extends AssetBundle
{
    /** @var string */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/jquery-knob/dist';

    /** @var string[] */
    public $js = ['jquery.knob.min.js'];

    /** @var string[] */
    public $depends = [
        JqueryAsset::class
    ];
}
