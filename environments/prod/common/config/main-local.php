<?php

use yii\db\Connection;
use yii\swiftmailer\Mailer;

return [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2_advanced_start',
            'username' => 'root',
            'password' => ''
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@common/mail'
        ]
    ]
];
