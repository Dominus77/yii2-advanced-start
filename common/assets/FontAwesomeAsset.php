<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Class FontAwesomeAsset
 * @package common\assets
 */
class FontAwesomeAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'css/font-awesome' . $min . '.css'
        ];
    }
}
