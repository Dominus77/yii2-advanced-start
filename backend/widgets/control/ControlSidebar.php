<?php

namespace backend\widgets\control;

use yii\bootstrap\Widget;
use yii\web\JsExpression;

/**
 * Class ControlSidebar
 * @package backend\themes\AdminLTE\widgets
 */
class ControlSidebar extends Widget
{
    /**
     * @var bool
     */
    public $status = true;

    /**
     * @var bool
     */
    public $demo = false;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->status === true) {
            $this->registerAssets();
            echo $this->render('controlSidebar');
        }
    }

    /**
     * @inheritdoc
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $script = new JsExpression("
            $('a[href=\"#control-sidebar-home-tab\"]').parent().removeClass('active');
            $('#control-sidebar-home-tab').removeClass('active');
        ");
        if ($this->demo === true) {
            DemoAsset::register($view);
            $view->registerJs($script);
        }
    }
}
