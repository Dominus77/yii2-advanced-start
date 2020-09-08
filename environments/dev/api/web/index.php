<?php

use yii\helpers\ArrayHelper;
use yii\web\Application;

require dirname(dirname(__DIR__)) . '/common/web/index.php';
require YII_APP_BASE_PATH . '/api/config/bootstrap.php';

$config = ArrayHelper::merge(
    require YII_APP_BASE_PATH . '/common/config/main.php',
    require YII_APP_BASE_PATH . '/common/config/main-local.php',
    require YII_APP_BASE_PATH . '/api/config/main.php',
    require YII_APP_BASE_PATH . '/api/config/main-local.php'
);

$application = new Application($config);
$application->run();
