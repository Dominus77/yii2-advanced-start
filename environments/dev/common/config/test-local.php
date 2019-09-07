<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=127.0.0.1;dbname=yii2_advanced_start_test'
            ]
        ]
    ]
);
