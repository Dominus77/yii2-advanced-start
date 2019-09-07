<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require dirname(dirname(__DIR__)) . '/common/config/test-local.php',
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    [
    ]
);
