<?php

use modules\users\Module;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('module', 'Update');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-frontend-default-update">
    <div class="nav-tabs-custom">
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Module::t('module', 'Profile'),
                    'content' => $this->render('update/_profile', [
                        'model' => $model,
                    ]),
                    'options' => ['id' => 'profile'],
                    'active' => (!Yii::$app->request->get('tab') || (Yii::$app->request->get('tab') == 'profile')) ? true : false,
                ],
                [
                    'label' => Module::t('module', 'Password'),
                    'content' => $this->render('update/_password', [
                        'model' => $model,
                    ]),
                    'options' => ['id' => 'password'],
                    'active' => (Yii::$app->request->get('tab') == 'password') ? true : false,
                ],
                [
                    'label' => Module::t('module', 'Photo'),
                    'content' => $this->render('update/_photo', [
                        'model' => $model,
                    ]),
                    'options' => ['id' => 'avatar'],
                    'active' => (Yii::$app->request->get('tab') == 'avatar') ? true : false,
                ],
            ]
        ]); ?>
    </div>
</div>
