<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use modules\users\Module;
use yii\bootstrap\Tabs;

$this->title = Module::t('module', 'Profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-frontend-default-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="nav-tabs-custom">
        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Html::encode($this->title),
                    'content' => $this->render('index/_profile', [
                        'model' => $model,
                    ]),
                    'options' => ['id' => 'profile'],
                    'active' => (!Yii::$app->request->get('tab') || (Yii::$app->request->get('tab') == 'profile')) ? true : false,
                ],
            ]
        ]); ?>
    </div>
</div>