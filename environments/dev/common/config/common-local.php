<?php

use yii\debug\Module as DebugModule;
use yii\gii\Module as GiiModule;
use common\gii\generators\module\Generator as ModuleGenerator;
use common\gii\generators\crud\Generator as CrudGenerator;

if (!YII_ENV_TEST && YII_DEBUG) {
    // configuring in debug mode
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => DebugModule::class
    ];
}
if (!YII_ENV_TEST && YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => GiiModule::class,
        'generators' => [
            'yii2-module' => [
                'class' => ModuleGenerator::class,
                'templates' => [
                    'mymodule' => '@common/gii/generators/module/default',
                ]
            ],
            'yii2-crud' => [
                'class' => CrudGenerator::class,
                'templates' => [
                    'mycrud' => '@common/gii/generators/crud/default',
                ]
            ],
        ]
    ];
}
