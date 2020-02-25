<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $link string
 */

$link =  Yii::$app->urlManager->createAbsoluteUrl(['main/default/index']);
?>
<div class="email-notice">
    <h2><?= Yii::t('app', 'Technical work completed.') ?></h2>
    <p><?= Yii::t('app', 'Please follow the link below to visit the site.') ?></p>
    <?= Html::a($link, $link) ?>
</div>
