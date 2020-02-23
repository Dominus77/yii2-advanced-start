<?php

use yii\helpers\Url;

/**
 * @var $this yii\web\View
 */

$link = Yii::$app->urlManager->hostInfo;
?>
Технические работы закончены.

This message allows you to visit our site home page by one click

<?= Url::home('http') ?>
