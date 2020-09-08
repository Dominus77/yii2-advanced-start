<?php

use yii\helpers\ArrayHelper;
use yii\web\Application;

$basePath = dirname(dirname(__DIR__));

require $basePath . '/common/web/index.php';
require $basePath . '/backend/config/bootstrap.php';

$config = ArrayHelper::merge(
    require $basePath . '/common/config/main.php',
    require $basePath . '/common/config/main-local.php',
    require $basePath . '/backend/config/main.php',
    require $basePath . '/backend/config/main-local.php'
);

$application = new Application($config);
$application->run();
