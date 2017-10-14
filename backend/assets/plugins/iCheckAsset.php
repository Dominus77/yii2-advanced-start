<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;

/**
 * Class iCheckAsset
 * @package backend\assets\plugins
 */
class iCheckAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'iCheck/all.css',
        ];
        $this->js = ['iCheck/icheck' . $min . '.js'];
        $view = \Yii::$app->getView();
        $view->registerJs(new \yii\web\JsExpression("
            $(function () {
                $('input.iCheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        "));
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
