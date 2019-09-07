<?php

use yii\swiftmailer\Mailer;
use yii\db\Connection;

return [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2_advanced_start',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@common/mail'
        ]
    ]
];
