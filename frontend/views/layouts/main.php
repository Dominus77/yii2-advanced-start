<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use modules\main\Module as MainModule;
use modules\users\Module as UserModule;

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
        ['label' => MainModule::t('module', 'Home'), 'url' => ['/main/default/index']],
        ['label' => MainModule::t('module', 'About'), 'url' => ['/main/default/about']],
        ['label' => MainModule::t('module', 'Contact'), 'url' => ['/main/default/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => UserModule::t('module', 'Sign Up'), 'url' => ['/users/default/signup']];
        $menuItems[] = ['label' => UserModule::t('module', 'Login'), 'url' => ['/users/default/login']];
    } else {
        /** @var modules\users\models\User $identity */
        $identity = Yii::$app->user->identity;
        $menuItems[] = [
            'label' => Yii::t('app', 'My Menu'),
            'items' => [
                ['label' => '<i class="glyphicon glyphicon-user"></i> ' . UserModule::t('module', 'Profile') . ' (' . $identity->username . ')', 'url' => ['/users/profile/index']],
                ['label' => '<i class="glyphicon glyphicon-log-out"></i> ' . UserModule::t('module', 'Sign Out'), 'url' => ['/users/default/logout'], 'linkOptions' => ['data-method' => 'post']],
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
