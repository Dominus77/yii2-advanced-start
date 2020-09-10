<?php

use yii\web\Application;

require dirname(dirname(__DIR__)) . '/common/web/index-test.php';
require YII_APP_BASE_PATH . '/frontend/config/bootstrap.php';

$config = require YII_APP_BASE_PATH . '/frontend/config/test-local.php';

$application = new Application($config);
$application->run();
