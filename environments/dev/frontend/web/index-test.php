<?php

use yii\web\Application;
use yii\base\InvalidConfigException;

defined('YII_APP_BASE_PATH') || define('YII_APP_BASE_PATH', dirname(dirname(__DIR__)) . '/');

require YII_APP_BASE_PATH . '/common/web/index-test.php';
require YII_APP_BASE_PATH . '/frontend/config/bootstrap.php';

try {
    $application = new Application($config);
} catch (InvalidConfigException $e) {
}

$application->run();
