<?php

use yii\helpers\ArrayHelper;

$messages = require dirname(dirname(dirname(__DIR__))) . '/common/messages/en/app.php';

return ArrayHelper::getValue($messages, []);
