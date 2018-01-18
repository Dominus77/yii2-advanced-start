<?php

return [
    'id' => 'app-frontend-tests',
    'language'=>'en',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend-test',
            'enableCsrfValidation' => false,
        ],
    ],
];
