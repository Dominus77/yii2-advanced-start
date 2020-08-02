<?php

use yii\web\Application;

defined('YII_APP_BASE_PATH') || define('YII_APP_BASE_PATH', dirname(dirname(__DIR__)) . '/');

require YII_APP_BASE_PATH . 'common/web/index-test.php';
require YII_APP_BASE_PATH . 'frontend/config/bootstrap.php';

$config = require YII_APP_BASE_PATH . 'frontend/config/test-local.php';

$application = new Application($config);
$application->run();
