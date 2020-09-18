<?php

use yii\helpers\ArrayHelper;

$messages = require dirname(dirname(dirname(__DIR__))) . '/common/messages/ru/app.php';

return ArrayHelper::merge($messages, [
    'Online' => 'В сети',
    'HEADER' => 'Главное меню',
    'Search' => 'Поиск',

    'No Authorize' => 'Не авторизован',

    'Go to Frontend' => 'Вернуться на сайт',

    'All rights reserved.' => 'Все права защищены.',

    'return to dashboard' => 'вернуться на главную страницу',
    'Meanwhile, you may {:Link} or try using the search form.' =>
        'Между тем, вы можете {:Link} или попробовать использовать форму поиска.',
    'More info' => 'Подробнее',
    'User Registrations' => 'Регистрации пользователей',
]);
