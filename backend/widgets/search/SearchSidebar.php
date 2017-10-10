<?php

namespace backend\widgets\search;

use Yii;

/**
 * Class SearchSidebar
 * @package backend\widgets\search
 */
class SearchSidebar extends \yii\bootstrap\Widget
{
    public $status = true;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->status == true) {
            echo $this->render('searchSidebar');
        }
    }
}