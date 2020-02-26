<?php

use yii\helpers\Html;
use frontend\widgets\timer\CountDown;
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
    'status' => true,
    'timestamp' => $model->timestamp,
    'message' => Yii::t('app', 'The site will work soon! Please refresh the page.'),
]) ?>
<br>
<div class="form-container">
    <?= SubscribeForm::widget([
        'status' => $model->isSubscribe(),
        'model' => $model
    ]) ?>
</div>
<div class="social-container"></div>
