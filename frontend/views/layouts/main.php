<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->name . ' | ' . Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('app', 'NAV_HOME'), 'url' => ['/site/index']],
        ['label' => Yii::t('app', 'NAV_ABOUT'), 'url' => ['/site/about']],
        ['label' => Yii::t('app', 'NAV_CONTACT'), 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'NAV_SIGN_UP'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'NAV_LOGIN'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => Yii::t('app', 'NAV_MY_MENU'),
            'items' => [
                ['label' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::t('app', 'NAV_PROFILE') .' ('.Yii::$app->user->identity->username.')', 'url' => ['/user/index']],
                ['label' => '<i class="glyphicon glyphicon-log-out"></i> ' . Yii::t('app', 'NAV_LOGOUT'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
            ],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'activateParents' => true,
        'encodeLabels' => false,
        'items' => array_filter($menuItems),
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
