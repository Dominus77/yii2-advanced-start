<?php

use modules\users\Module;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'TITLE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-default-update">
    <div class="nav-tabs-custom">
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Module::t('backend', 'TITLE_PROFILE'),
                    'content' => $this->render('update/_profile', [
                        'model' => $model,
                    ]),
                    'active' => (Yii::$app->request->get('tab') == 'profile') ? true : false,
                ],
                [
                    'label' => Module::t('backend', 'TITLE_PASSWORD'),
                    'content' => $this->render('update/_password', [
                        'model' => $model,
                    ]),
                    'active' => (Yii::$app->request->get('tab') == 'password') ? true : false,
                ],
                [
                    'label' => Module::t('backend', 'TITLE_PHOTO'),
                    'content' => $this->render('update/_photo', [
                        'model' => $model,
                    ]),
                    'active' => (Yii::$app->request->get('tab') == 'avatar') ? true : false,
                ],
            ]
        ]); ?>
    </div>
</div>
