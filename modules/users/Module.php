<?php

namespace modules\users;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * users module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\users\controllers\frontend';

    /**
     * @var boolean Если модуль используется для админ-панели.
     */
    public $isBackend;

    /**
     * Upload avatar path
     * @var string
     */
    public $uploads = 'uploads/users';

    /**
     * Size avatar image (width. height)
     * @var array
     */
    public $imageSize = [160, 160];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();

        // Это здесь для того, чтобы переключаться между frontend и backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\users\controllers\backend';
            $this->setViewPath('@modules/users/views/backend');
        } else {
            $this->setViewPath('@modules/users/views/frontend');
            if (Yii::$app instanceof ConsoleApplication) {
                $this->controllerNamespace = 'modules\users\commands';
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/users/*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@modules/users/messages',
            'fileMap'        => [
                'modules/users/backend' => 'backend.php',
                'modules/users/frontend' => 'frontend.php',
                'modules/users/mail' => 'mail.php',
            ],
        ];
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
        return Yii::t('modules/users/' . $category, $message, $params, $language);
    }
}
