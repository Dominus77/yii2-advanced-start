<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

// phpcs:disable
defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'test');
defined('YII_APP_BASE_PATH') || define('YII_APP_BASE_PATH', dirname(dirname(__DIR__)));

require YII_APP_BASE_PATH . '/vendor/autoload.php';
require YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php';
require YII_APP_BASE_PATH . '/common/config/bootstrap.php';
// phpcs:enable
