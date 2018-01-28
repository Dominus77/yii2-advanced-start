<?php

namespace modules\users\traits;

use Yii;
use modules\users\Module;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 * @package modules\users\traits
 */
trait ModuleTrait
{
    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('users');
    }
}
