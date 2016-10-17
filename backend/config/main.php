<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'language'=>'ru_RU',
    'homeUrl' => '/admin',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'main/default/index',
    'bootstrap' => ['log'],
    'modules' => [
        'main' => [
            'isBackend' => true,
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'modules\main\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['/main/default/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'errorAction' => 'main/default/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'main/default/index',
                '<_a:[\w\-]+>' => 'main/default/<_a>',
            ],
        ],
    ],
    'as afterAction' => [
        'class' => '\common\components\behavior\LastVisitBehavior',
    ],
    'params' => $params,
];
