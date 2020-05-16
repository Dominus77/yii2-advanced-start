<?php

namespace modules\users;

use Yii;

/**
 * Class Bootstrap
 * @package modules\users
 */
class Bootstrap
{
    public function __construct()
    {
        $this->registerTranslate();

        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules((Yii::$app->id === 'app-backend') ? [$this->rulesBackend()] : [$this->rulesFrontend()]);
    }

    /**
     * Translate
     */
    protected function registerTranslate()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['modules/users/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/users/messages',
            'fileMap' => [
                'modules/users/module' => 'module.php',
                'modules/users/mail' => 'mail.php',
            ],
        ];
    }

    /**
     * Group rules backend
     * @return array
     */
    protected function rulesBackend()
    {
        return [
            'class' => 'yii\web\GroupUrlRule',
            'rules' => [
                'login' => 'users/default/login',
                'logout' => 'users/default/logout',
                'users' => 'users/default/index',
                'user/<id:\d+>/<_a:[\w\-]+>' => 'users/default/<_a>',
                'user/<_a:[\w\-]+>' => 'users/default/<_a>',

                'profile' => 'users/profile/index',
                'profile/<id:\d+>/<_a:[\w\-]+>' => 'users/profile/<_a>',
                'profile/<_a:[\w\-]+>' => 'users/profile/<_a>',
            ],
        ];
    }

    /**
     * Group rules frontend
     * @return array
     */
    protected function rulesFrontend()
    {
        return [
            'class' => 'yii\web\GroupUrlRule',
            'rules' => [
                'profile' => 'users/profile/index',
                'profile/<_a:[\w\-]+>' => 'users/profile/<_a>',

                'email-confirm' => 'users/default/email-confirm',
                'user/<_a:[\w\-]+>' => 'users/default/<_a>',
            ],
        ];
    }
}
