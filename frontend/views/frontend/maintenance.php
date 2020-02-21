<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

$this->title = $name;
?>
<div class="frontend-maintenance">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= Html::encode($message) ?>
    </div>
</div>
