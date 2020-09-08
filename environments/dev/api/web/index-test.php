<?php

use yii\web\Application;

require dirname(dirname(__DIR__)) . '/common/web/index-test.php';
require YII_APP_BASE_PATH . '/api/config/bootstrap.php';

$config = require YII_APP_BASE_PATH . '/api/config/test-local.php';

$application = new Application($config);
$application->run();
