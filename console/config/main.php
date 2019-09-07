<?php

use yii\log\FileTarget;
use yii\console\controllers\MigrateController;
use yii\helpers\ArrayHelper;
use modules\rbac\Module as RbacModule;
use modules\main\Bootstrap as MainBootstrap;
use modules\users\Bootstrap as UserBootstrap;
use modules\rbac\Bootstrap as RbacBootstrap;
use modules\users\models\User;

$params = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        MainBootstrap::class,
        UserBootstrap::class,
        RbacBootstrap::class
    ],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationNamespaces' => [
                'modules\rbac\migrations',
                'modules\users\migrations'
            ]
        ]
    ],
    'modules' => [
        'rbac' => [
            'class' => RbacModule::class,
            'params' => [
                'userClass' => User::class
            ]
        ]
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning']
                ]
            ]
        ]
    ],
    'params' => $params
];
