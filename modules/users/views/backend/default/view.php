<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use modules\rbac\models\Assignment;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $assignModel Assignment
 */

$this->title = Module::translate('module', 'View');
$this->params['title']['small'] = $model->username;

$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::translate('module', 'View');

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
                        'label' => Module::translate('module', 'Profile'),
                        'content' => $this->render('tabs/_view_profile', [
                            'model' => $model,
                            'assignModel' => $assignModel,
                        ]),
                        'options' => ['id' => 'profile'],
                        'active' => !Yii::$app->request->get('tab') || (Yii::$app->request->get('tab') === 'profile'),
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
