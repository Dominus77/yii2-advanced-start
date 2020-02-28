<?php

use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $link string
 */

$link = Url::to(Yii::$app->urlManager->hostInfo);
?>
<?= Yii::t('app', 'Technical work completed.') ?>
<?= Yii::t('app', 'Please follow the link below to visit the site.') ?>

<?= $link ?>
