<?php

namespace modules\main;

use Yii;
use yii\filters\RateLimiter;

/**
 * Class Module
 * @package modules\main
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => RateLimiter::class
            ]
        ];
    }

    /**
     * @var string
     */
    public $controllerNamespace = 'modules\main\controllers\frontend';

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
            $this->controllerNamespace = 'modules\main\controllers\backend';
            $this->setViewPath('@modules/main/views/backend');
        } else {
            $this->setViewPath('@modules/main/views/frontend');
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
        return Yii::t('modules/main/' . $category, $message, $params, $language);
    }
}
