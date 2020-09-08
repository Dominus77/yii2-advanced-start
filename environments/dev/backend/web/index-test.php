<?php

use yii\web\Application;

$basePath = dirname(dirname(__DIR__));

require $basePath . '/common/web/index-test.php';
require $basePath . '/backend/config/bootstrap.php';

$config = require $basePath . '/backend/config/test-local.php';

$application = new Application($config);
$application->run();
