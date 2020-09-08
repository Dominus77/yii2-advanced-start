<?php

use yii\web\Application;

require dirname(dirname(__DIR__)) . '/common/web/index-test.php';
require YII_APP_BASE_PATH . '/backend/config/bootstrap.php';

$config = require YII_APP_BASE_PATH . '/backend/config/test-local.php';

$application = new Application($config);
$application->run();
