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
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\users\controllers\frontend';

    /**
     * @var boolean Если модуль используется для админ-панели.
     */
    public $isBackend;

    /**
     * @var boolean Если модуль используется для RESTful.
     */
    public $isApi;

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
     * Allow Extensions uploaded file
     * @var string
     */
    public $ext = 'png, jpg';

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
        } else if($this->isApi === true) {
            $this->controllerNamespace = 'modules\users\controllers\api';
        } else {
            $this->setViewPath('@modules/users/views/frontend');
            if (Yii::$app instanceof ConsoleApplication) {
                $this->controllerNamespace = 'modules\users\commands';
            }
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
        return Yii::t('modules/users/' . $category, $message, $params, $language);
    }
}
