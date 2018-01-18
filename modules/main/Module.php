<?php

namespace modules\main;

use Yii;

/**
 * main module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => \yii\filters\RateLimiter::className(),
            ],
        ];
    }

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

        // Это здесь для того, чтобы переключаться между frontend и backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\main\controllers\backend';
            $this->setViewPath('@modules/main/views/backend');
        } else {
            $this->setViewPath('@modules/main/views/frontend');
        }
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
