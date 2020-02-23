<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 */

$link = Yii::$app->urlManager->hostInfo
?>
<div class="email-notice">
    <h2>Технические работы закончены.</h2>
    <p>This message allows you to visit our site home page by one click</p>
    <?= Html::a(Url::home('http'), Url::home('http')) ?>
</div>
