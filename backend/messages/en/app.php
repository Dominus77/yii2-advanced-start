<?php

use yii\helpers\ArrayHelper;

$messages = require __DIR__ . '/../../../common/messages/en/app.php';

return ArrayHelper::merge($messages, [
    'Online' => 'Online',
    'HEADER' => 'General menu',
    'Search' => 'Search',

    'No Authorize' => 'No Authorize',

    'Go to Frontend' => 'Go to Frontend',

    'All rights reserved.' => 'All rights reserved.',

    'return to dashboard' => 'return to dashboard',
    'Meanwhile, you may {:Link} or try using the search form.' => 'Meanwhile, you may {:Link} or try using the search form.'
]);
