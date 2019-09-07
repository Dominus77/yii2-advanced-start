<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Class IonIconsAsset
 * @package common\assets
 */
class IonIconsAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/driftyco/ionicons';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = ['css/ionicons' . $min . '.css'];
    }
}
