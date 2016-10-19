<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'TITLE_VIEW_USER');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-default-view">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->username) ?></h3>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'first_name',
                    'last_name',
                    'email:email',
                    [
                        'attribute' => 'role',
                        'format' => 'raw',
                        'value' => $model->userRoleName,
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => $model->statusLabelName,
                    ],
                    'last_visit:datetime',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::t('backend', 'BUTTON_UPDATE'), ['update', 'id' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Module::t('backend', 'BUTTON_DELETE'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Module::t('backend', 'CONFIRM_DELETE'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
