<?php

use yii\helpers\Html;
use frontend\widgets\timer\CountDown;
use common\components\maintenance\widgets\SubscribeForm;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

$this->title = $name;
$date = new DateTime('23-02-2020 23:00:00');
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
<br>
<div class="form-container">
    <?= SubscribeForm::widget() ?>
</div>
