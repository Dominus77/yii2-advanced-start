<?php

namespace backend\assets\plugins;

use yii\web\AssetBundle;
use yii\web\JsExpression;

/**
 * Class iCheckAsset
 * @package backend\assets\plugins
 */
class iCheckAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

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
        $min = YII_ENV_DEV ? '' : '.min';
        $this->css = [
            'iCheck/all.css',
        ];
        $this->js = ['iCheck/icheck' . $min . '.js'];
        $view = \Yii::$app->getView();
        $view->registerJs(new JsExpression("
            $(function () {
                $('input.iCheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        "));
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\BootstrapAsset',
    ];
}
