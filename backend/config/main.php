<?php

use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\log\FileTarget;
use yii\web\UrlManager;
use yii\helpers\ArrayHelper;
use dominus77\maintenance\BackendMaintenance;
use dominus77\maintenance\controllers\backend\MaintenanceController;
use modules\rbac\models\Permission;
use modules\users\models\User;
use modules\rbac\components\behavior\AccessBehavior;
use modules\users\behavior\LastVisitBehavior;
use modules\main\Bootstrap as MainBootstrap;
use modules\users\Bootstrap as UserBootstrap;
use modules\rbac\Bootstrap as RbacBootstrap;
use modules\rbac\Module;

$params = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'en', // en, ru
    'homeUrl' => '/admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'main/default/index',
    'bootstrap' => [
        'log',
        MainBootstrap::class,
        UserBootstrap::class,
        RbacBootstrap::class,
        BackendMaintenance::class
    ],
    'modules' => [
        'main' => [
            'isBackend' => true
        ],
        'users' => [
            'isBackend' => true
        ],
        'rbac' => [
            'class' => Module::class,
            'params' => [
                'userClass' => User::class
            ]
        ]
    ],
    'controllerMap' => [
        'maintenance' => [
            'class' => MaintenanceController::class,
            'roles' => [Permission::PERMISSION_MANAGER_MAINTENANCE]
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin'
        ],
        'assetManager' => [
            'bundles' => [
                BootstrapAsset::class => [
                    'sourcePath' => '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist',
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css'
                    ]
                ],
                BootstrapPluginAsset::class => [
                    'sourcePath' => '@vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist',
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js'
                    ]
                ]
            ]
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['/users/default/login']
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning']
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'backend/error'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => []
        ],
        'urlManagerFrontend' => [
            'class' => UrlManager::class,
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'email-confirm' => 'users/default/email-confirm'
            ]
        ]
    ],
    // Последний визит
    'as afterAction' => [
        'class' => LastVisitBehavior::class
    ],
    // Доступ к админке
    'as AccessBehavior' => [
        'class' => AccessBehavior::class,
        'permission' => Permission::PERMISSION_VIEW_ADMIN_PAGE, // Разрешение доступа к админке
    ],
    'params' => $params
];
