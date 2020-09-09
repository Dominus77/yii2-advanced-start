<?php

namespace modules\rbac;

use Yii;
use yii\console\Application as ConsoleApplication;
use modules\users\models\User;

/**
 * Class Module
 * @package modules\rbac
 */
class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $userClass = User::class;

    /**
     * @var string
     */
    public $controllerNamespace = 'modules\rbac\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\rbac\console';
        }
        $this->setViewPath('@modules/rbac/views');
    }

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param string|null $language
     * @return string
     */
    public static function translate($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/rbac/' . $category, $message, $params, $language);
    }
}
