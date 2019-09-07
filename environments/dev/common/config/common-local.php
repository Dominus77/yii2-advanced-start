<?php

use yii\debug\Module as DebugModule;
use yii\gii\Module as GiiModule;

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
