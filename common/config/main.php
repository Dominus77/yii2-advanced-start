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
        ],
    ],
];
