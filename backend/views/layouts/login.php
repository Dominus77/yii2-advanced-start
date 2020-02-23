<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LoginAsset;
use common\widgets\Alert;
use yii\web\View;

/* @var $this View */
/* @var $content string */

LoginAsset::register($this);
$homeUrl = is_string(Yii::$app->homeUrl) ? Yii::$app->homeUrl : '/';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->name . ' | ' . Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php $this->head() ?>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>
<div class="row">
    <div class="col-md-12">
        <?= Alert::widget([
            'options' => [
                'style' => 'text-align:center;'
            ]
        ]) ?>
    </div>
</div>
<div class="login-box">
    <div class="login-logo">
        <a href="<?= $homeUrl ?>"><b>Admin</b>LTE</a><br>
        <?= Yii::$app->name ?>
    </div>
    <div class="login-box-body">
        <?= $content ?>
    </div>
    <div class="login-box-footer">
        <a href="<?= Url::to('/') ?>"><?= Yii::t('app', 'Go to Frontend') ?></a>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
