<?php

use yii\helpers\ArrayHelper;

$messages = require dirname(dirname(dirname(__DIR__))) . '/common/messages/ru/app.php';

return ArrayHelper::merge($messages, [
    'My Menu' => 'Моё меню',

    'Search' => 'Поиск',
    'All rights reserved.' => 'Все права защищены.',
    'The above error occurred while the Web server was processing your request.' =>
        'Вышеупомянутая ошибка возникла, когда веб-сервер обрабатывал ваш запрос.',
    'Please contact us if you think this is a server error. Thank you.' =>
        'Если вы считаете, что это ошибка сервера, свяжитесь с нами. Спасибо.',
]);
