<?php

namespace backend\widgets\navbar;

use yii\bootstrap\Widget;

/**
 * Class NotificationsWidget
 * @package backend\widgets\navbar
 */
class NotificationsWidget extends Widget
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
            echo $this->render('notificationsWidget');
        }
    }
}
