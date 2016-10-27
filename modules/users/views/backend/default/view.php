<?php

use modules\users\Module;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'TITLE_VIEW_USER');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-default-view">
    <div class="nav-tabs-custom">
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Module::t('backend', 'TITLE_PROFILE'),
                    'content' => $this->render('view/_profile', [
                        'model' => $model,
                    ]),
                    'active' => (Yii::$app->request->get('tab') == 'profile') ? true : false,
                ],
            ]
        ]); ?>
    </div>
</div>
