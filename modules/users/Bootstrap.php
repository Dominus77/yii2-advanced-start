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
        $app->getUrlManager()->addRules(
            [
                // объявление правил здесь
                '<_a:(signup|login|request-password-reset|logout)>' => 'users/default/<_a>',

                'users' => 'users/default/index',
                'users/create' => 'users/default/create',
                'users/<id:\d+>/<_a:[\w\-]+>' => 'users/default/<_a>',
            ]
        );
    }
}