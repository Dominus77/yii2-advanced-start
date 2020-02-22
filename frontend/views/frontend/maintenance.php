<?php

use yii\helpers\Html;
use common\components\maintenance\widgets\timer\CountDown;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

$this->title = $name;
$date = new DateTime('23-02-2020 09:00:00');
$timestamp = $date->getTimestamp();
?>

<h1><?= Html::encode($this->title) ?></h1>
<p><?= $message ?></p>

<?= CountDown::widget([
    'status' => true,
    'clientOptions' => [
        'timestamp' => $timestamp,
    ]
]) ?>
