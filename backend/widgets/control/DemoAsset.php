<?php

namespace backend\widgets\control;

use yii\web\AssetBundle;

/**
 * Class DemoAsset
 * @package backend\widgets\control
 */
class DemoAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';

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
        $this->js = [
            'js/demo.js'
        ];
    }
}
