<?php

namespace modules\main;

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

        // Это здесь для того, чтобы переключаться между frontend и backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\main\controllers\backend';
            $this->setViewPath('@modules/main/views/backend');
        } else {
            $this->setViewPath('@modules/main/views/frontend');
        }
    }
}
