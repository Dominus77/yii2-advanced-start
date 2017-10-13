<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 17.10.16
 * Time: 13:36
 */

namespace modules\users;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // i18n
        $app->i18n->translations['modules/users/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/users/messages',
            'fileMap' => [
                'modules/users/backend' => 'backend.php',
                'modules/users/frontend' => 'frontend.php',
                'modules/users/mail' => 'mail.php',
            ],
        ];

        // Rules
        $app->getUrlManager()->addRules(
            [
                // Rules
                '<_a:(login|logout|signup|email-confirm|request-password-reset|reset-password)>' => 'users/default/<_a>',

                // Users
                'users' => 'users/default/index',
                'users/create' => 'users/default/create',
                'users/<id:\d+>/<_a:[\w\-]+>' => 'users/default/<_a>',

                // Profile
                'user' => 'users/profile/index',
                'user/update' => 'users/profile/update',
                'user/update-profile' => 'users/profile/update-profile',
                'user/update-avatar' => 'users/profile/update-avatar',
                'user/update-password' => 'users/profile/update-password',
                'user/delete' => 'users/profile/delete',
            ]
        );
    }
}