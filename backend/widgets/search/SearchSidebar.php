<?php

namespace backend\widgets\search;

use yii\bootstrap\Widget;

/**
 * Class SearchSidebar
 * @package backend\widgets\search
 */
class SearchSidebar extends Widget
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
            echo $this->render('searchSidebar');
        }
    }
}
