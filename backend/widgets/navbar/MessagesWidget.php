<?php

namespace backend\widgets\navbar;

use Yii;

/**
 * Class MessagesWidget
 * @package backend\widgets\search
 */
class MessagesWidget extends \yii\bootstrap\Widget
{
    /**
     * @var bool
     */
    public $status = true;

    public $image = '';

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->status === true) {
            echo $this->render('messagesWidget', ['image' => $this->image]);
        }
    }
}
