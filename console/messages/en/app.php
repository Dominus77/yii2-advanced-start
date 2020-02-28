<?php

use yii\helpers\ArrayHelper;

$messages = require __DIR__ . '/../../../common/messages/en/app.php';

return ArrayHelper::getValue($messages, []);
