<?php

use yii\helpers\ArrayHelper;
use yii\web\Application;

$basePath = dirname(dirname(__DIR__));

require $basePath . '/common/web/index.php';
require $basePath . '/api/config/bootstrap.php';

$config = ArrayHelper::merge(
    require $basePath . '/common/config/main.php',
    require $basePath . '/common/config/main-local.php',
    require $basePath . '/api/config/main.php',
    require $basePath . '/api/config/main-local.php'
);

$application = new Application($config);
$application->run();
