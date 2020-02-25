<?php

/**
 * @var $this yii\web\View
 * @var $link string
 */

$link =  Yii::$app->urlManager->createAbsoluteUrl(['main/default/index']);
?>
<?= Yii::t('app', 'Technical work completed.') ?>
<?= Yii::t('app', 'Please follow the link below to visit the site.') ?>

<?= $link ?>
