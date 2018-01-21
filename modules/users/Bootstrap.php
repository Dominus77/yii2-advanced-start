<?php
namespace modules\users;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package modules\users
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        // i18n
        $app->i18n->translations['modules/users/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/users/messages',
            'fileMap' => [
                'modules/users/module' => 'module.php',
                'modules/users/mail' => 'mail.php',
            ],
        ];

        // Rules
        $app->getUrlManager()->addRules(
            [
                // Rules
                '<_a:(login|logout|signup|email-confirm|request-password-reset|reset-password)>' => 'users/default/<_a>',
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'users/default',
                    'prefix' => 'user',
                    'rules' => [
                        '<_a:(create)>' => '<_a>',
                        '<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'users/default',
                    'prefix' => 'users',
                    'rules' => [
                        '' => 'index',
                        '<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'users/profile',
                    'prefix' => 'profile',
                    'rules' => [
                        '' => 'index',
                        '<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
            ]
        );
    }
}
