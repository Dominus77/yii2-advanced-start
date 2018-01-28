<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use modules\users\widgets\AvatarWidget;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $assignModel \modules\rbac\models\Assignment */

?>

<div class="row">
    <div class="col-sm-2">
        <?= AvatarWidget::widget([
            'email' => $model->email,
            'imageOptions' => [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'margin-bottom:10px; width:auto',
                'alt' => 'avatar_' . $model->username,
            ]
        ]) ?>
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
                    'value' => function ($model) use ($assignModel) {
                        return $assignModel->getRoleName($model->id);
                    },
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $view = Yii::$app->controller->view;
                        /** @var object $identity */
                        $identity = Yii::$app->user->identity;
                        if ($model->id != $identity->id) {
                            $view->registerJs("$('#status_link_" . $model->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
                            return Html::a($model->statusLabelName, Url::to(['status', 'id' => $model->id]), [
                                'id' => 'status_link_' . $model->id,
                                'title' => Module::t('module', 'Click to change the status'),
                                'data' => [
                                    'toggle' => 'tooltip',
                                ],
                            ]);
                        }
                        return $model->statusLabelName;
                    },
                    'contentOptions' => [
                        'class' => 'link-decoration-none',
                    ],
                ],
                [
                    'attribute' => 'auth_key',
                    'format' => 'raw',
                    'value' => $this->render('../../../common/profile/col_auth_key', ['model' => $model, 'url' => Url::to(['generate-auth-key', 'id' => $model->id])]),
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'value' => Yii::$app->formatter->asDatetime($model->created_at, 'd LLL yyyy, H:mm:ss'),
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => 'raw',
                    'value' => Yii::$app->formatter->asDatetime($model->updated_at, 'd LLL yyyy, H:mm:ss'),
                ],
                [
                    'attribute' => 'last_visit',
                    'format' => 'raw',
                    'value' => Yii::$app->formatter->asDatetime($model->last_visit, 'd LLL yyyy, H:mm:ss'),
                ],
                [
                    'attribute' => 'registration_type',
                    'format' => 'raw',
                    'value' => $model->registrationType,
                ],
            ],
        ]) ?>
    </div>

    <div class="col-sm-offset-2 col-sm-10">

        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::t('module', 'Update'), ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary',
        ]) ?>

        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Module::t('module', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('module', 'Are you sure you want to delete the record?'),
                'method' => 'post',
            ],
        ]) ?>

    </div>
</div>
