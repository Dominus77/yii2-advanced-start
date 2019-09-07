<?php

namespace backend\widgets\navbar;

use yii\bootstrap\Widget;

/**
 * Class TasksWidget
 * @package backend\widgets\navbar
 */
class TasksWidget extends Widget
{
    /**
     * @var bool
     */
    public $status = true;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->status === true) {
            echo $this->render('tasksWidget');
        }
    }
}
