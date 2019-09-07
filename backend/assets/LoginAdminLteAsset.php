<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use common\assets\FontAwesomeAsset;
use common\assets\IonIconsAsset;
use backend\assets\plugins\iCheckAsset;
use common\assets\Html5ShivAsset;
use common\assets\RespondAsset;

/**
 * Class LoginAdminLteAsset
 * @package backend\assets
 */
class LoginAdminLteAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = ['css/AdminLTE' . $min . '.css'];
    }

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        FontAwesomeAsset::class,
        IonIconsAsset::class,
        iCheckAsset::class,
        Html5ShivAsset::class,
        RespondAsset::class
    ];
}
