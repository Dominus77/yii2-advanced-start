<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
        'modules\rbac\Bootstrap',
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'modules\users\models\User',
        ],
    ],
];
