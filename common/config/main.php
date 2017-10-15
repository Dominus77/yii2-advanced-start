<?php
return [
    'name' => 'Yii2-advanced-start',
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'main' => [
            'class' => 'modules\main\Module',
        ],
        'users' => [
            'class' => 'modules\users\Module',
        ],
        'rbac' => [
            'class' => 'modules\rbac\Module',
        ],
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=nameDb',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'useFileTransport' => false,
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'basePath' => '@app/web/assets',
            'converter' => [
                'class' => 'nizsheanez\assetConverter\Converter',
                'force' => false, // true : If you want convert your sass each time without time dependency
                'destinationDir' => 'compiled', //at which folder of @webroot put compiled files
                'parsers' => [
                    'less' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Less',
                        'output' => 'css', // parsed output file type
                        'options' => [
                            'auto' => true, // optional options
                        ],
                    ],
                ],
            ],
        ],
    ],
];
