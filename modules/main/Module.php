<?php

namespace modules\main;

use Yii;

/**
 * main module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\main\controllers\frontend';

    /**
     * @var boolean Если модуль используется для админ-панели.
     */
    public $isBackend;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();

        // Это здесь для того, чтобы переключаться между frontend и backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\main\controllers\backend';
            $this->setViewPath('@modules/main/views/backend');
        } else {
            $this->setViewPath('@modules/main/views/frontend');
        }
    }

    /**
     * @inheritdoc
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/main/*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@modules/main/messages',
            'fileMap'        => [
                'modules/main/backend' => 'backend.php',
                'modules/main/frontend' => 'frontend.php',
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
        return Yii::t('modules/main/' . $category, $message, $params, $language);
    }
}
