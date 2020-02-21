<?php

namespace common\components\maintenance;

use yii\base\BaseObject;

/**
 * Class Filter
 * @package common\components\maintenance
 */
abstract class Filter extends BaseObject
{
    /**
     * @return bool
     */
    abstract public function isAllowed();
}