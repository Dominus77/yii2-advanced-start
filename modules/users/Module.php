<?php

namespace modules\users;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package modules\users
 */
class Module extends \yii\base\Module
{
    /**
     * Время в сек, когда пользователей со статусом "Ожидает", можно удалять
     * В основном для Cron задачи.
     * ```
     * php yii users/cron/remove-overdue
     * ```
     * @var int
     */
    public $emailConfirmTokenExpire = 259200; // 3 days

    /**
     * @var int
     */
    public static $passwordResetTokenExpire = 3600;

    /**
     * @var string
     */
    public $controllerNamespace = 'modules\users\controllers\frontend';

    /**
     * @var bool Если модуль используется для админ-панели.
     */
    public $isBackend;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Это здесь для того, чтобы переключаться между frontend и backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\users\controllers\backend';
            $this->setViewPath('@modules/users/views/backend');
        } else {
            $this->setViewPath('@modules/users/views/frontend');
        }
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\users\commands';
        }
    }

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/users/' . $category, $message, $params, $language);
    }
}
