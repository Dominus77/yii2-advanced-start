<?php

use yii\gii\Module as GiiModule;
use yii\debug\Module as DebugModule;

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => ''
        ]
    ]
];

if (!YII_ENV_TEST || YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => DebugModule::class
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => GiiModule::class
    ];
}

return $config;
