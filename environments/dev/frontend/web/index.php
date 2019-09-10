<?php

use yii\helpers\ArrayHelper;
use yii\web\Application;
use yii\base\InvalidConfigException;

defined('YII_APP_BASE_PATH') || define('YII_APP_BASE_PATH', dirname(dirname(__DIR__)) . '/');

require YII_APP_BASE_PATH . '/common/web/index.php';
require YII_APP_BASE_PATH . '/frontend/config/bootstrap.php';

$config = ArrayHelper::merge(
    require YII_APP_BASE_PATH . '/common/config/main.php',
    require YII_APP_BASE_PATH . '/common/config/main-local.php',
    require YII_APP_BASE_PATH . '/frontend/config/main.php',
    require YII_APP_BASE_PATH . '/frontend/config/main-local.php'
);

try {
    $application = new Application($config);
} catch (InvalidConfigException $e) {
    // Exception
}

$application->run();
