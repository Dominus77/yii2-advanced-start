<?php
return [
    'id' => 'app-backend-tests',
    'language'=>'en',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend-test',
            'enableCsrfValidation' => false,
        ],
    ],
];
