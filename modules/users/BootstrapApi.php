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
                'PUT,PATCH users/<id>' => 'users/default/update',
                'DELETE users/<id>' => 'users/default/delete',
                'GET,HEAD users/<id>' => 'users/default/view',
                'POST users' => 'users/default/create',
                'GET,HEAD users' => 'users/default/index',
                'users/<id>' => 'users/default/options',
                'users' => 'users/default/options',
            ]
        );
        parent::bootstrap($app);
    }
}