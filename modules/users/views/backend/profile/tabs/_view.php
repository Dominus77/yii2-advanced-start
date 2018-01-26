<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\users\widgets\AvatarWidget;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $assignModel \modules\rbac\models\Assignment */
?>

<div class="row">
    <div class="col-sm-2">
        <?= AvatarWidget::widget() ?>
    </div>
    <div class="col-sm-10">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'first_name',
                'last_name',
                'email:email',
                [
                    'attribute' => 'userRoleName',
                    'format' => 'raw',
                    'value' => $assignModel->getRoleName($model->id),
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => $model->statusLabelName,
                ],
                [
                    'attribute' => 'auth_key',
                    'format' => 'raw',
                    'value' => $this->render('../../../common/profile/col_auth_key', ['model' => $model]),
                ],
                'created_at:datetime',
                'updated_at:datetime',
                'last_visit:datetime',
                [
                    'attribute' => 'registration_type',
                    'format' => 'raw',
                    'value' => $model->registrationType,
                ],
            ],
        ]) ?>
    </div>
    <div class="col-sm-offset-2 col-sm-10">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::t('module', 'Update'), ['update'], [
            'class' => 'btn btn-primary'
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Module::t('module', 'Delete'), ['delete'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('module', 'Are you sure you want to delete the record?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
