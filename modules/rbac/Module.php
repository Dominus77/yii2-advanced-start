<?php

namespace modules\rbac;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\rbac\controllers\backend';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setViewPath('@modules/rbac/views/backend');
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\rbac\commands';
        }
    }
}
