<?php

use yii\web\User as WebUser;
use modules\users\models\User;
use modules\main\Bootstrap as MainBootstrap;
use modules\users\Bootstrap as UserBootstrap;
use modules\rbac\Bootstrap as RbacBootstrap;

return [
    'name' => 'Yii2-advanced-start',
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        MainBootstrap::class,
        UserBootstrap::class,
        RbacBootstrap::class
    ],
    'components' => [
        'user' => [
            'class' => WebUser::class,
            'identityClass' => User::class
        ]
    ]
];
