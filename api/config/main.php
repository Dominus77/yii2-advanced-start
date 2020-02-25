<?php

use yii\caching\FileCache;
use yii\rest\UrlRule;
use yii\log\FileTarget;
use yii\web\JsonParser;
use yii\helpers\ArrayHelper;
use api\modules\v1\models\User;
use api\modules\v1\Module as V1Module;
use modules\users\Bootstrap as UserBootstrap;

$params = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'language' => 'en', // en, ru
    'homeUrl' => '/api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        UserBootstrap::class
    ],
    'modules' => [
        'v1' => [
            'class' => V1Module::class   // here is our v1 modules
        ]
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => JsonParser::class
            ]
        ],
        'user' => [
            'identityClass' => User::class,
            'enableSession' => false,
            'enableAutoLogin' => false,
            'loginUrl' => null
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => UrlRule::class,
                    'controller' => [
                        'v1/user'
                    ],
                    'except' => ['delete'],
                    'pluralize' => true
                ],
                [
                    'class' => UrlRule::class,
                    'controller' => [
                        'v1/message'
                    ],
                    'pluralize' => false
                ]
            ]
        ],
        'cache' => [
            'class' => FileCache::class
        ]
    ],
    'params' => $params
];
