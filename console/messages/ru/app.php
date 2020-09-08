<?php

use yii\helpers\ArrayHelper;

$messages = require dirname(dirname(dirname(__DIR__))) . '/common/messages/ru/app.php';

return ArrayHelper::merge($messages, []);
