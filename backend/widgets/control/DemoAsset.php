<?php

namespace backend\widgets\control;

use yii\web\AssetBundle;

/**
 * Class DemoAsset
 * @package backend\widgets\control
 */
class DemoAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $js;

    public function init()
    {
        parent::init();
        $this->js = [
            'js/demo.js'
        ];
    }
}
