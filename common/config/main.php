<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
    	'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=nameDb',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',            
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],        
    ],
];
