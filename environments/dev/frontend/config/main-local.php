<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => ''
        ]
    ]
];

include dirname(dirname(__DIR__)) . '/common/config/common-local.php';

return $config;
