<?php

use yii\web\Application;

$basePath = dirname(dirname(__DIR__));

require $basePath . '/common/web/index-test.php';
require $basePath . '/api/config/bootstrap.php';

$config = require $basePath . '/api/config/test-local.php';

$application = new Application($config);
$application->run();
