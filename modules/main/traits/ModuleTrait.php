<?php

namespace modules\main\traits;

use Yii;
use modules\main\Module;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 * @package modules\main\traits
 */
trait ModuleTrait
{
    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('main');
    }
}
