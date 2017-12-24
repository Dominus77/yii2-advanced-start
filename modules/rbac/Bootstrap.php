<?php

namespace modules\rbac;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package modules\rbac
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // i18n
        $app->i18n->translations['modules/rbac/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/rbac/messages',
            'fileMap' => [
                'modules/rbac/module' => 'module.php',
            ],
        ];

        // Rules
        $app->getUrlManager()->addRules(
            [
                // Roles
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'rbac/roles',
                    'prefix' => 'rbac',
                    'rules' => [
                        'roles' => 'index',
                        'role/<id:[\w\-]+>/<_a:[\w\-]+>' => '<_a>',
                        'role/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Permissions
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'rbac/permissions',
                    'prefix' => 'rbac',
                    'rules' => [
                        'permissions' => 'index',
                        'permission/<id:[\w\-]+>/<_a:[\w\-]+>' => '<_a>',
                        'permission/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Assign
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'rbac/assign',
                    'prefix' => 'rbac/assign',
                    'rules' => [
                        '' => 'index',
                        '<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Default
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'rbac/default',
                    'prefix' => 'rbac',
                    'rules' => [
                        '' => 'index',
                        '<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
            ]
        );
    }
}