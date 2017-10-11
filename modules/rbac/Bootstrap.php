<?php

namespace modules\rbac;

use yii\base\BootstrapInterface;

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
                // объявление правил здесь
                'rbac' => 'rbac/default/index',
                'rbac/reset' => 'rbac/default/reset',

                'rbac/roles' => 'rbac/roles/index',
                'rbac/roles/create' => 'rbac/roles/create',
                'rbac/roles/add-permissions' => 'rbac/roles/add-permissions',
                'rbac/roles/remove-permissions' => 'rbac/roles/remove-permissions',
                'rbac/roles/add-roles' => 'rbac/roles/add-roles',
                'rbac/roles/remove-roles' => 'rbac/roles/remove-roles',
                'rbac/roles/<id:[\w\-]+>/<_a:[\w\-]+>' => 'rbac/roles/<_a>',

                'rbac/permissions' => 'rbac/permissions/index',
                'rbac/permissions/create' => 'rbac/permissions/create',
                'rbac/permissions/add-permissions' => 'rbac/permissions/add-permissions',
                'rbac/permissions/remove-permissions' => 'rbac/permissions/remove-permissions',
                'rbac/permissions/<id:[\w\-]+>/<_a:[\w\-]+>' => 'rbac/permissions/<_a>',

                'rbac/assign' => 'rbac/assign/index',
                'rbac/assign/<id:\d+>/<_a:[\w\-]+>' => 'rbac/assign/<_a>',
            ]
        );
    }
}