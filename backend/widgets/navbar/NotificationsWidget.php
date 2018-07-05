<?php

namespace backend\widgets\navbar;

use Yii;

/**
 * Class NotificationsWidget
 * @package backend\widgets\navbar
 */
class NotificationsWidget extends \yii\bootstrap\Widget
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
