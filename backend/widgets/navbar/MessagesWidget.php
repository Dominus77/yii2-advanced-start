<?php

namespace backend\widgets\navbar;

use yii\bootstrap\Widget;

/**
 * Class MessagesWidget
 * @package backend\widgets\search
 */
class MessagesWidget extends Widget
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
