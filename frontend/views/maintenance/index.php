<?php

use yii\helpers\Html;
use common\widgets\timer\CountDown;
use common\components\maintenance\models\SubscribeForm as ModelSubscribeForm;
use common\components\maintenance\widgets\SubscribeForm;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $model ModelSubscribeForm */

$this->title = $name;
?>

<h1><?= Html::encode($this->title) ?></h1>
<p><?= $message ?></p>
<br>
<?= CountDown::widget([
    'status' => $model->isTimer(),
    'timestamp' => $model->timestamp,
    'message' => Yii::t('app', 'The site will work soon! Please refresh the page.'),
]) ?>
<div class="form-container">
    <?php if (($status = $model->isSubscribe()) && $status === true) { ?>
        <p><?= Yii::t('app', 'We can notify you when everything is ready.') ?></p>
        <?= SubscribeForm::widget([
            'status' => $status,
            'model' => $model
        ]) ?>
    <?php } ?>
</div>
<div class="social-container"></div>
