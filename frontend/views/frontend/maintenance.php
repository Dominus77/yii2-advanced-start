<?php

use yii\helpers\Html;
use frontend\widgets\timer\CountDown;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

$this->title = $name;
$date = new DateTime('25-02-2020 19:40:00');
$timestamp = $date->getTimestamp();
?>

<h1><?= Html::encode($this->title) ?></h1>
<p><?= $message ?></p>
<br>
<?= CountDown::widget([
    'status' => true,
    'timestamp' => $timestamp,
    'message' => Yii::t('app', 'Done! Please update this page.'),
]) ?>
