<?php

use modules\users\Module;
use yii\bootstrap\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('module', 'Update');
$this->params['title']['small'] = $model->username;

$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('module', 'Update');
?>
<div class="users-backend-default-update">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->username); ?></h3>
        </div>
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
</div>
