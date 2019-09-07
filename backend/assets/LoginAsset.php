<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class LoginAsset
 * @package backend\assets
 */
class LoginAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $basePath = '@webroot';

    /**
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * @var array
     */
    public $css = [
        'css/login.css'
    ];

    /**
     * @var array
     */
    public $depends = [
        LoginAdminLteAsset::class
    ];
}
