<?php

namespace backend\widgets\search;

use Yii;

/**
 * Class SearchSidebar
 * @package backend\widgets\search
 */
class SearchSidebar extends \yii\bootstrap\Widget
{
    /**
     * @var bool
     */
    public $status = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->status === true) {
            echo $this->render('searchSidebar');
        }
    }
}
