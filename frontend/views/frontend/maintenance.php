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

//\yii\helpers\VarDumper::dump($model->datetime, 10, 1);
//\yii\helpers\VarDumper::dump($model->timestamp, 10, 1);
//\yii\helpers\VarDumper::dump($model->emails, 10, 1);

?>

<h1><?= Html::encode($this->title) ?></h1>
<p><?= $message ?></p>
<br>
<?= CountDown::widget([
    'status' => true,
    'timestamp' => $model->timestamp,
    'message' => Yii::t('app', 'Done! Please update this page.'),
]) ?>
<br>
<div class="form-container">
    <?= SubscribeForm::widget([
        'status' => true,
        'model' => $model
    ]) ?>
</div>
<div class="social-container"></div>
