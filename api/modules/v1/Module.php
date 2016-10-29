<?php

namespace api\modules\v1;

use Yii;
use modules\users\Module as ModuleUsers;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        ModuleUsers::registerTranslations();
    }
}
