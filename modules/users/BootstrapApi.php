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
                        'users/user'
                    ],
                    'except' => ['delete'],
                    'pluralize' => true,
                ],
            ]
        );
        parent::bootstrap($app);
    }
}