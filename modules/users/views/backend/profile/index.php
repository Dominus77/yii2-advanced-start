<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use modules\rbac\models\Assignment;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $assignModel Assignment
 */

$this->title = Module::translate('module', 'Profile');
$this->params['breadcrumbs'][] = $this->title;

$items = [
    [
        'label' => Html::encode($this->title),
        'content' => $this->render('tabs/_view', [
            'model' => $model,
            'assignModel' => $assignModel
        ]),
        'options' => ['id' => 'profile', 'role' => 'tabpanel'],
        'active' => !Yii::$app->request->get('tab') || (Yii::$app->request->get('tab') === 'profile')
    ]
];
?>

<div class="users-backend-profile-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->username) ?></h3>
        </div>
        <div class="nav-tabs-custom">
            <?= Tabs::widget([
                'options' => ['role' => 'tablist'],
                'items' => $items
            ]) ?>
        </div>
    </div>
</div>
