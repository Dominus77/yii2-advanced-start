<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
?>

<div class="row">
    <div class="col-sm-2">
        <?php if ($model->avatar) : ?>
            <?= Html::img($model->getAvatarPath(), [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'margin-bottom:10px; width:auto',
            ]); ?>
        <?php else : ?>
            <div class="col-sm-10 text-center">
                <i class="fa fa-user-circle fa-5x" style="color:#b9b9b9; margin-bottom:10px;"></i>
            </div>
        <?php endif; ?>
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
                    'attribute' => 'role',
                    'format' => 'raw',
                    'value' => $model->userRoleName,
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => $model->statusLabelName,
                ],
                'auth_key',
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
