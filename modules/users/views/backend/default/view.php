<?php

use modules\users\Module;
use yii\bootstrap\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'TITLE_USERS');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('backend', 'TITLE_VIEW');
?>
<div class="users-backend-default-view">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->username); ?></h3>
        </div>
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
</div>
