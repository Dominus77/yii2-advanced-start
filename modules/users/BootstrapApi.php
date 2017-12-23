<?php

namespace modules\users;

/**
 * Class BootstrapApi
 * @package modules\users
 */
class BootstrapApi extends Bootstrap
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            [
                // Rules for RESTful
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'users/default'
                    ],
                ],
                // @see http://www.yiiframework.com/doc-2.0/guide-rest-routing.html
                'PUT,PATCH user/<id>' => 'users/default/update',
                'DELETE user/<id>' => 'users/default/delete',
                'GET,HEAD user/<id>' => 'users/default/view',
                'POST user' => 'users/default/create',
                'GET,HEAD users' => 'users/default/index',
                'user/<id>' => 'users/default/options',
                'users' => 'users/default/options',
            ]
        );
        parent::bootstrap($app);
    }
}