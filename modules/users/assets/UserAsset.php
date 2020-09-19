<?php

namespace modules\users\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class UserAsset
 * @package modules\users\assets
 */
class UserAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '';

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
        $this->sourcePath = __DIR__ . '/src';
        $this->js = ['js/user.js'];
    }

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
    ];
}
