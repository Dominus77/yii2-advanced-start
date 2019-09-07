<?php

use yii\swiftmailer\Mailer;

return [
    'components' => [
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@common/mail'
        ]
    ]
];
