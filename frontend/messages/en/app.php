<?php

use yii\helpers\ArrayHelper;

$messages = require dirname(dirname(dirname(__DIR__))) . '/common/messages/en/app.php';

return ArrayHelper::merge($messages, [
    'My Menu' => 'My Menu',

    'Search' => 'Search',
    'All rights reserved.' => 'All rights reserved.',
    'The above error occurred while the Web server was processing your request.' =>
        'The above error occurred while the Web server was processing your request.',
    'Please contact us if you think this is a server error. Thank you.' =>
        'Please contact us if you think this is a server error. Thank you.'
]);
