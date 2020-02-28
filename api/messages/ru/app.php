<?php

use yii\helpers\ArrayHelper;

$messages = require __DIR__ . '/../../../common/messages/ru/app.php';

return ArrayHelper::merge($messages, [
    'Exceeded the limit of applications!' => 'Превышен лимит обращений!'
]);
