<?php

namespace backend\widgets\control;

use Yii;

/**
 * Class ControlSidebar
 * @package backend\themes\AdminLTE\widgets
 */
class ControlSidebar extends \yii\bootstrap\Widget
{
    public $status = true;
    public $demo = false;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->status == true) {
            $this->registerAssets();
            echo $this->render('controlSidebar');
        }
    }

    public function registerAssets()
    {
        $view = $this->getView();
        $script = new \yii\web\JsExpression("
            $('a[href=\"#control-sidebar-home-tab\"]').parent().removeClass('active');
            $('#control-sidebar-home-tab').removeClass('active');
        ");
        if($this->demo == true) {
            DemoAsset::register($view);
            $view->registerJs($script);
        }
    }
}