<?php

namespace modules\rbac;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package modules\rbac
 */
class Module extends \yii\base\Module
{
    /**
     * @var string $userClass
     */
    public $userClass = 'modules\users\models\User';

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
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\rbac\console';
        }
        $this->setViewPath('@modules/rbac/views/backend');
    }

    /**
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/rbac/' . $category, $message, $params, $language);
    }
}
