<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $link string
 */

$link = Url::to(Yii::$app->urlManager->hostInfo);
?>
<div class="email-notice">
    <h2><?= Yii::t('app', 'Technical work completed.') ?></h2>
    <p><?= Yii::t('app', 'Please follow the link below to visit the site.') ?></p>
    <?= Html::a($link, $link) ?>
</div>
