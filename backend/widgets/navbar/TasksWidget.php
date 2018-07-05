<?php

namespace backend\widgets\navbar;

use Yii;

/**
 * Class TasksWidget
 * @package backend\widgets\navbar
 */
class TasksWidget extends \yii\bootstrap\Widget
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
