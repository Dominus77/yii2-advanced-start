<?php
defined('YII_APP_BASE_PATH') || define('YII_APP_BASE_PATH', __DIR__ . '/../../../../');
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/test-local.php'),
    require(YII_APP_BASE_PATH . '/frontend/config/test-local.php'),
    require(__DIR__ . '/test.php'),
    [
    ]
);
