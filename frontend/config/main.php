<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

/**
 * This Bootstrap Css Theme
 * @package /common/themes/bootstrap
 * @var string
 *
 * Css Themes:
 * ------------
 * cerulean
 * cosmo
 * cyborg
 * darkly
 * flatly
 * journal
 * lumen
 * paper
 * readable
 * sandstone
 * simplex
 * slate
 * spacelab
 * superhero
 * united
 * yeti
 * ------------
 */
$bootstrap_theme = 'cerulean';

return [
    'id' => 'app-frontend',
    'language' => 'ru',
    'homeUrl' => '/',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
        'modules\rbac\Bootstrap',
    ],
    'defaultRoute' => 'main/default/index',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'assetManager' => [
            'bundles' => [
                // Comment this component for theme bootstrap default
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@common/themes/bootstrap',
                    'css' => [
                        YII_ENV_DEV ? $bootstrap_theme . '/bootstrap.css' : $bootstrap_theme . '/bootstrap.min.css',
                    ]
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'modules\users\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['/users/default/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'frontend/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [],
        ],
    ],
    'as afterAction' => [
        'class' => '\modules\users\behavior\LastVisitBehavior',
    ],
    'params' => $params,
];
