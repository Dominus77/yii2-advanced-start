<?php

use yii\web\Application;

defined('YII_APP_BASE_PATH') || define('YII_APP_BASE_PATH', dirname(dirname(__DIR__)) . '/');

require YII_APP_BASE_PATH . 'common/web/index-test.php';
require YII_APP_BASE_PATH . 'api/config/bootstrap.php';

$application = new Application($config);
$application->run();
