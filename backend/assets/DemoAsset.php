<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class DemoAsset
 * @package backend\assets
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
