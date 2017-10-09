<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class LoginAdminLteAsset
 * @package backend\assets
 */
class LoginAdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = ['css/AdminLTE' . $min . '.css'];

        $view = \Yii::$app->getView();
        $view->registerJs(new \yii\web\JsExpression("
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        "));
    }

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\BootstrapAsset',
        'common\assets\FontAwesomeAsset',
        'common\assets\IonIconsAsset',
        'backend\assets\plugins\iCheckAsset',
        'common\assets\Html5ShivAsset',
        'common\assets\RespondAsset'
    ];
}
