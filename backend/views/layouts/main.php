<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use backend\assets\plugins\ICheckAsset;
use backend\widgets\control\ControlSidebar;
use backend\widgets\navbar\MessagesWidget;
use backend\widgets\navbar\NotificationsWidget;
use backend\widgets\navbar\TasksWidget;
use backend\widgets\search\SearchSidebar;
use modules\rbac\models\Permission;
use modules\users\models\User;
use dominus77\noty\NotyWidget;
use modules\users\widgets\AvatarWidget;
use modules\main\Module as MainModule;
use modules\users\Module as UserModule;
use modules\rbac\Module as RbacModule;

/* @var $this View */
/* @var $content string */

ICheckAsset::register($this);
AppAsset::register($this);

NotyWidget::widget([
    'typeOptions' => [
        NotyWidget::TYPE_SUCCESS => ['timeout' => 3000],
        NotyWidget::TYPE_INFO => ['timeout' => 3000],
        NotyWidget::TYPE_ALERT => ['timeout' => 3000],
        NotyWidget::TYPE_ERROR => ['timeout' => 5000],
        NotyWidget::TYPE_WARNING => ['timeout' => 3000]
    ],
    'options' => [
        'progressBar' => true,
        'timeout' => false,
        'layout' => NotyWidget::LAYOUT_TOP_CENTER,
        'dismissQueue' => true,
        'theme' => NotyWidget::THEME_SUNSET
    ],
]);

/** @var yii\web\User $user */
$user = Yii::$app->user;
/* @var User $identity */
$identity = $user->identity;
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
                <span class="fas fa-bars"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <?= MessagesWidget::widget([
                        'status' => true,
                        'image' => $publishedUrl ? Html::img($publishedUrl . '/img/user2-160x160.jpg', [
                            'class' => 'img-circle',
                            'alt' => 'User Image'
                        ]) : '']) ?>

                    <?= NotificationsWidget::widget(['status' => true]) ?>

                    <?= TasksWidget::widget(['status' => true]) ?>

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?= AvatarWidget::widget([
                                'user_id' => $user->id,
                                'imageOptions' => [
                                    'class' => 'user-image'
                                ]
                            ]) ?>
                            <span class="hidden-xs"><?= $fullUserName ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <?= AvatarWidget::widget([
                                    'user_id' => $user->id
                                ]) ?>
                                <p>
                                    <?= $fullUserName ?>
                                    <small>
                                        <?= UserModule::translate('module', 'Member since') . ' ' . $formatter->asDatetime($identity->created_at, 'LLL yyyy') // phpcs:ignore                 ?>
                                    </small>
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
                                    <a href="<?= Url::to(['/users/profile/index']) ?>"
                                       class="btn btn-default btn-flat">
                                        <?= UserModule::translate('module', 'Profile') ?>
                                    </a>
                                </div>
                                <div class="pull-right">
                                    <?= Html::beginForm(['/users/default/logout'])
                                    . Html::submitButton(UserModule::translate('module', 'Sign Out'), [
                                        'class' => 'btn btn-default btn-flat logout'
                                    ]) . Html::endForm() ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fas fa-cogs"></i></a>
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
                        'user_id' => $user->id
                    ]) ?>
                </div>
                <div class="pull-left info">
                    <p><?= $fullUserName ?></p>
                    <a href="#">
                        <i class="fas fa-circle text-success"></i> <?= Yii::t('app', 'Online') ?>
                    </a>
                </div>
            </div>

            <?= SearchSidebar::widget(['status' => true]) ?>

            <?php
            $items = [
                [
                    'label' => Yii::t('app', 'HEADER'),
                    'options' => ['class' => 'header']
                ],
                [
                    'label' => $this->render('_label', [
                        'icon' => 'fas fa-tachometer-alt',
                        'title' => MainModule::translate('module', 'Home')
                    ]),
                    'url' => ['/main/default/index']
                ],
                [
                    'label' => $this->render('_label', [
                        'icon' => 'fa fa-users',
                        'title' => UserModule::translate('module', 'Users')
                    ]),
                    'url' => ['/users/default/index'],
                    'visible' => $user->can(Permission::PERMISSION_MANAGER_USERS)
                ],
                [
                    'label' => $this->render('_label', [
                        'isRoot' => true,
                        'icon' => 'fa fa-unlock',
                        'title' => RbacModule::translate('module', 'RBAC')
                    ]),
                    'url' => ['/rbac/default/index'],
                    'options' => ['class' => 'treeview'],
                    'visible' => $user->can(Permission::PERMISSION_MANAGER_RBAC),
                    'items' => [
                        [
                            'label' => $this->render('_label', [
                                'icon' => 'far fa-circle',
                                'title' => RbacModule::translate('module', 'Permissions')
                            ]),
                            'url' => ['/rbac/permissions/index']
                        ],
                        [
                            'label' => $this->render('_label', [
                                'icon' => 'far fa-circle',
                                'title' => RbacModule::translate('module', 'Roles')
                            ]),
                            'url' => ['/rbac/roles/index']
                        ],
                        [
                            'label' => $this->render('_label', [
                                'icon' => 'far fa-circle',
                                'title' => RbacModule::translate('module', 'Assign')
                            ]),
                            'url' => ['/rbac/assign/index']
                        ]
                    ]
                ],
                [
                    'label' => $this->render('_label', [
                        'icon' => 'fa fa-wrench',
                        'title' => Yii::t('app', 'Mode site')
                    ]),
                    'url' => ['/maintenance/index'],
                    'visible' => $user->can(Permission::PERMISSION_MANAGER_MAINTENANCE)
                ],
                [
                    'label' => $this->render('_label', [
                        'title' => Yii::t('app', 'Another Link')
                    ]),
                    'url' => ['#']
                ],
                [
                    'label' => $this->render('_label', [
                        'isRoot' => true,
                        'title' => Yii::t('app', 'Multilevel')
                    ]),
                    'url' => ['#'],
                    'options' => ['class' => 'treeview'],
                    'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                        [
                            'label' => $this->render('_label', [
                                'icon' => 'far fa-circle',
                                'title' => Yii::t('app', 'Link in level 2')
                            ]),
                            'url' => ['#']
                        ],
                        [
                            'label' => $this->render('_label', [
                                'isRoot' => true,
                                'icon' => 'far fa-circle',
                                'title' => Yii::t('app', 'Link in level 2')
                            ]),
                            'url' => ['#'],
                            'options' => ['class' => 'treeview'],
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Link in level 3'),
                                    'url' => ['#']
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            echo Menu::widget([
                'options' => ['class' => 'sidebar-menu'],
                'encodeLabels' => false,
                'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
                'activateParents' => true,
                'items' => $items
            ]);
            ?>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <?php
                $small = isset($this->params['title']['small']) ?
                    ' ' . Html::tag('small', Html::encode($this->params['title']['small'])) : '';
                echo Html::encode($this->title) . $small ?>
            </h1>
            <?= Breadcrumbs::widget([
                'homeLink' => [
                    'label' => '<i class="fa fa-dashboard"></i> ' . MainModule::translate('module', 'Home'),
                    'url' => Url::to(['/main/default/index'])],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'encodeLabels' => false
            ]) ?>
        </section>
        <section class="content">
            <?= $content ?>
        </section>

    </div>

    <footer class="main-footer">

        <div class="pull-right hidden-xs">

        </div>
        <strong>&copy; <?= date('Y') ?> <a
                    href="#"><?= Yii::$app->name ?></a>.</strong>
        <?= Yii::t('app', 'All rights reserved.') ?>
    </footer>

    <?= ControlSidebar::widget([
        'status' => true,
        'demo' => false
    ]) ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
