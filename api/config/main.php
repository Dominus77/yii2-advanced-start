<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            //'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'   // here is our v1 modules
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
            'identityClass' => 'api\users\models\User',
            'enableSession' => false,
            'loginUrl' => null,
            //'enableAutoLogin' => true,
            //'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
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
                    'controller' => 'v1/user',
                    'except' => ['delete'],
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            /*'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ]
            ],*/
        ],
    ],
    'params' => $params,
];