<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use modules\main\Module as MainModule;
use modules\users\Module as UserModule;

/* @var $this View */
/* @var $content string */

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
        'brandLabel' => Html::img('@web/images/logo.png', [
                'alt' => Yii::$app->name, 'class' => 'yii-logo'
            ]) . Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top'
        ]
    ]);
    $menuItems = [
        [
            'label' => MainModule::translate('module', 'Home'),
            'url' => [
                '/main/default/index'
            ]
        ],
        [
            'label' => MainModule::translate('module', 'About'),
            'url' => [
                '/main/default/about'
            ]
        ],
        [
            'label' => MainModule::translate('module', 'Contact'),
            'url' => [
                '/main/default/contact'
            ]
        ]
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => UserModule::translate('module', 'Sign Up'),
            'url' => [
                '/users/default/signup'
            ]
        ];
        $menuItems[] = [
            'label' => UserModule::translate('module', 'Login'),
            'url' => [
                '/users/default/login'
            ]
        ];
    } else {
        /** @var modules\users\models\User $identity */
        $identity = Yii::$app->user->identity;
        $menuItems[] = [
            'label' => Yii::t('app', 'My Menu'),
            'items' => [
                [
                    'label' => $this->render('_label', [
                        'icon' => 'glyphicon glyphicon-user',
                        'title' => UserModule::translate('module', 'Profile') .
                            ' (' . $identity->username . ')'
                    ]),
                    'url' => [
                        '/users/profile/index'
                    ]
                ],
                [
                    'label' => $this->render('_label', [
                        'icon' => 'glyphicon glyphicon-log-out',
                        'title' => UserModule::translate('module', 'Sign Out')
                    ]),
                    'url' => [
                        '/users/default/logout'
                    ],
                    'linkOptions' => [
                        'data-method' => 'post'
                    ]
                ]
            ]
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'activateParents' => true,
        'encodeLabels' => false,
        'items' => array_filter($menuItems)
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name . ' ' . date('Y') ?></p>

        <p class="pull-right">
            Работает на <a href="http://www.yiiframework.com/" target="_blank">Yii Framework</a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
