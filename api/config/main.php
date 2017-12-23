<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'modules\users\BootstrapApi',
    ],
    'modules' => [
        // Url http://yii2-advanced-start.loc/api/v1/users
        // Url http://yii2-advanced-start.loc/api/v1/users/1
        'v1' => [
            'class' => 'api\modules\v1\Module'   // here is our v1 modules
        ],
        // Url http://yii2-advanced-start.loc/api/users
        // Url http://yii2-advanced-start.loc/api/user/1
        'users' => [
            'isApi' => true,
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'modules\users\models\api\User',
            'enableSession' => false,
            'loginUrl' => null,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/user'
                    ],
                    'except' => ['delete'],
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/message'
                    ],
                    'pluralize' => false,
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'params' => $params,
];