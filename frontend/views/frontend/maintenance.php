<?php

use yii\helpers\Html;
use frontend\widgets\timer\CountDown;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

$this->title = $name;
$date = new DateTime('22-02-2020 23:00:00');
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
    <form class="form-inline">
        <div class="form-group">
            <label class="sr-only" for="exampleInputAmount">Email</label>
            <div class="input-group">
                <div class="input-group-addon">@</div>
                <input type="text" class="form-control" id="exampleInputAmount" placeholder="Email">
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Notify me') ?></button>
    </form>
</div>
