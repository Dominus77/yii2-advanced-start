<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use backend\assets\plugins\iCheckAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use modules\users\widgets\AvatarWidget;
use modules\main\Module as MainModule;
use modules\users\Module as UserModule;
use modules\rbac\Module as RbacModule;

iCheckAsset::register($this);
AppAsset::register($this);

/* @var \modules\users\models\User $identity */
$identity = Yii::$app->user->identity;
$fullUserName = ($identity !== null) ? $identity->getUserFullName() : Yii::t('app', 'No Authorize');

$assetManager = Yii::$app->assetManager;
/** @var false|string $publishedUrl */
$publishedUrl = $assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$formatter = Yii::$app->formatter;
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
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
    <header class="main-header">

        <a href="<?= $homeUrl ?>" class="logo">
            <span class="logo-mini"><b>A</b>LT</span>
            <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <?= \backend\widgets\navbar\MessagesWidget::widget([
                        'status' => true,
                        'image' => $publishedUrl ? Html::img($publishedUrl . '/img/user2-160x160.jpg', [
                            'class' => 'img-circle',
                            'alt' => 'User Image',
                        ]) : '',]) ?>

                    <?= \backend\widgets\navbar\NotificationsWidget::widget(['status' => true]) ?>

                    <?= \backend\widgets\navbar\TasksWidget::widget(['status' => true]) ?>

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?= AvatarWidget::widget([
                                'imageOptions' => [
                                    'class' => 'user-image',
                                ],
                            ]); ?>
                            <span class="hidden-xs"><?= $fullUserName ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <?= AvatarWidget::widget(); ?>
                                <p>
                                    <?= $fullUserName ?>
                                    <small><?= UserModule::t('module', 'Member since') . ' ' . $formatter->asDatetime($identity->created_at, 'LLL yyyy') ?></small>
                                </p>
                            </li>
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?= Url::to(['/users/profile/index']); ?>"
                                       class="btn btn-default btn-flat"><?= UserModule::t('module', 'Profile'); ?></a>
                                </div>
                                <div class="pull-right">
                                    <?= Html::beginForm(['/users/default/logout'], 'post')
                                    . Html::submitButton(UserModule::t('module', 'Sign Out'), ['class' => 'btn btn-default btn-flat logout'])
                                    . Html::endForm(); ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">

        <section class="sidebar">

            <div class="user-panel">
                <div class="pull-left image">
                    <?= AvatarWidget::widget(); ?>
                </div>
                <div class="pull-left info">
                    <p><?= $fullUserName ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?= Yii::t('app', 'Online'); ?></a>
                </div>
            </div>

            <?= \backend\widgets\search\SearchSidebar::widget(['status' => true]); ?>

            <?php
            $items = [
                [
                    'label' => Yii::t('app', 'HEADER'),
                    'options' => ['class' => 'header',],
                ],
                [
                    'label' => '<i class="fa fa-dashboard"></i> <span>' . MainModule::t('module', 'Home') . '</span>',
                    'url' => ['/main/default/index'],
                ],
                [
                    'label' => '<i class="fa fa-users"></i> <span>' . UserModule::t('module', 'Users') . '</span>',
                    'url' => ['/users/default/index'],
                    'visible' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_USERS),
                ],
                [
                    'label' => '<i class="fa fa-unlock"></i> <span>' . RbacModule::t('module', 'RBAC') . '</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>',
                    'url' => ['/rbac/default/index'],
                    'options' => ['class' => 'treeview'],
                    'visible' => Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_RBAC),
                    'items' => [
                        [
                            'label' => '<i class="fa fa-circle-o"> </i><span>' . RbacModule::t('module', 'Permissions') . '</span>',
                            'url' => ['/rbac/permissions/index'],
                        ],
                        [
                            'label' => '<i class="fa fa-circle-o"> </i><span>' . RbacModule::t('module', 'Roles') . '</span>',
                            'url' => ['/rbac/roles/index'],
                        ],
                        [
                            'label' => '<i class="fa fa-circle-o"> </i><span>' . RbacModule::t('module', 'Assign') . '</span>',
                            'url' => ['/rbac/assign/index'],
                        ],
                    ],
                ],
                [
                    'label' => '<i class="fa fa-link"></i> <span>' . Yii::t('app', 'Another Link') . '</span>',
                    'url' => ['#'],
                ],
                [
                    'label' => '<i class="fa fa-link"></i> <span>' . Yii::t('app', 'Multilevel') . '</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>',
                    'url' => ['#'],
                    'options' => ['class' => 'treeview'],
                    'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                        [
                            'label' => '<i class="fa fa-circle-o"> </i><span>' . Yii::t('app', 'Link in level 2') . '</span>',
                            'url' => ['#'],
                        ],
                        [
                            'label' => '<i class="fa fa-circle-o"> </i><span>' . Yii::t('app', 'Link in level 2') . '</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>',
                            'url' => ['#'],
                            'options' => ['class' => 'treeview'],
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Link in level 3'),
                                    'url' => ['#'],
                                ],
                            ]
                        ],
                    ],
                ],
            ];
            echo Menu::widget([
                'options' => ['class' => 'sidebar-menu',],
                'encodeLabels' => false,
                'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                'activateParents' => true,
                'items' => $items,
            ]);
            ?>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <?php
                $small = isset($this->params['title']['small']) ? ' ' . Html::tag('small', Html::encode($this->params['title']['small'])) : '';
                echo Html::encode($this->title) . $small ?>
            </h1>
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> ' . MainModule::t('module', 'Home'), 'url' => Url::to(['/main/default/index'])],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'encodeLabels' => false,
            ]) ?>
            <?= Alert::widget() ?>
        </section>
        <section class="content">
            <?= $content ?>
        </section>

    </div>

    <footer class="main-footer">

        <div class="pull-right hidden-xs">

        </div>
        <strong>&copy; <?= date('Y') ?> <a
                    href="#"><?= Yii::$app->name ?></a>.</strong> <?= Yii::t('app', 'All rights reserved.'); ?>
    </footer>

    <?= \backend\widgets\control\ControlSidebar::widget([
        'status' => true,
        'demo' => false,
    ]) ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
