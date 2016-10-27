<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use modules\rbac\models\Rbac as BackendRbac;
use modules\users\components\widgets\AvatarWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '-')); ?>">
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

        <a href="<?= Yii::$app->homeUrl ?>" class="logo">
            <span class="logo-mini"><b>A</b>LT</span>
            <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img
                                                    src="<?= Yii::$app->getAssetManager()->getPublishedUrl('@adminlte/dist') . '/img/user2-160x160.jpg' ?>"
                                                    class="img-circle"
                                                    alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>

                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?= AvatarWidget::widget([
                                'defaultOptions' => [
                                    'class' => 'fa fa-user-circle',
                                    'style' => 'color:#b9b9b9',
                                ],
                                'imageOtions' => [
                                    'class' => 'user-image',
                                ],
                            ]); ?>
                            <span class="hidden-xs"><?= Yii::$app->user->identity->getUserFullName(); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <?= AvatarWidget::widget([
                                    'defaultOptions' => [
                                        'class' => 'fa fa-user-circle fa-5x',
                                        'style' => 'color:#b9b9b9',
                                    ],
                                    'imageOtions' => [
                                        'class' => 'img-circle',
                                    ],
                                ]); ?>
                                <p>
                                    <?= Yii::$app->user->identity->getUserFullName(); ?>
                                    - <?= Yii::$app->user->identity->getUserRoleName(); ?>
                                    <small><?= Yii::t('app', 'Member since') . ' ' . Yii::$app->formatter->asDatetime(Yii::$app->user->identity->created_at, 'LLL yyyy'); ?></small>
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
                                    <a href="<?= Url::to(['/users/default/view', 'id' => Yii::$app->user->identity->getId()]); ?>"
                                       class="btn btn-default btn-flat"><?= Yii::t('app', 'Profile'); ?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= Url::to(['/users/default/logout']); ?>" data-method="post"
                                       class="btn btn-default btn-flat"><?= Yii::t('app', 'Sign out'); ?></a>
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
                    <?= AvatarWidget::widget([
                        'defaultOptions' => [
                            'class' => 'fa fa-user-circle fa-3x',
                            'style' => 'color:#b9b9b9',
                        ],
                        'imageOtions' => [
                            'class' => 'img-circle',
                        ],
                    ]); ?>
                </div>
                <div class="pull-left info">
                    <p><?= Yii::$app->user->identity->getUserFullName(); ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?= Yii::t('app', 'Online'); ?></a>
                </div>
            </div>

            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="<?= Yii::t('app', 'Search...'); ?>">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <?php
            $items = [
                [
                    'label' => Yii::t('app', 'HEADER'),
                    'options' => ['class' => 'header',],
                ],
                [
                    'label' => '<i class="fa fa-dashboard"></i> <span>' . Yii::t('app', 'Home') . '</span>',
                    'url' => ['/main/default/index'],
                ],
                [
                    'label' => '<i class="fa fa-users"></i> <span>' . Yii::t('app', 'Users') . '</span>',
                    'url' => ['/users/default/index'],
                    'visible' => Yii::$app->user->can(BackendRbac::ROLE_MODERATOR),
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
                <?= Html::encode($this->title) ?>
                <br>
            </h1>
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> ' . Yii::t('app', 'Home'), 'url' => Url::to(['/main/default/index'])],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'encodeLabels' => false,
            ]) ?>
        </section>
        <section class="content">
            <?= Alert::widget([
                'options' => [
                    //'style' => 'position:absolute; z-index:999999; opacity:0.8;',
                ]
            ]) ?>
            <?= $content ?>
        </section>

    </div>

    <footer class="main-footer">

        <div class="pull-right hidden-xs">

        </div>
        <strong>&copy; <?= date('Y') ?> <a
                href="#"><?= Yii::$app->name ?></a>.</strong> <?= Yii::t('app', 'All rights reserved.'); ?>
    </footer>


    <aside class="control-sidebar control-sidebar-dark">

        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading"><?= Yii::t('app', 'Recent Activity'); ?></h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>

                <h3 class="control-sidebar-heading"><?= Yii::t('app', 'Tasks Progress'); ?></h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript::;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="pull-right-container">
                                  <span class="label label-danger pull-right">70%</span>
                                </span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>


            </div>

            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading"><?= Yii::t('app', 'General Settings'); ?></h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </aside>
    <div class="control-sidebar-bg"></div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
