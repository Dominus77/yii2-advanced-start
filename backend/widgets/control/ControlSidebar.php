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

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->status == true) {
            echo $this->render('controlSidebar');
        }
    }
}