<?php

use yii\helpers\ArrayHelper;

$messages = require __DIR__ . '/../../../common/messages/en/app.php';

return ArrayHelper::merge($messages, [
    'Exceeded the limit of applications!' => 'Exceeded the limit of applications!'
]);
