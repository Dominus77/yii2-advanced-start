<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use modules\rbac\models\Assignment;
use modules\users\widgets\AvatarWidget;
use modules\users\assets\UserAsset;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $assignModel Assignment
 */

UserAsset::register($this);

?>

<div class="row">
    <div class="col-sm-2">
        <?= AvatarWidget::widget([
            'email' => $model->profile->email_gravatar,
            'user_id' => $model->id,
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
                'profile.first_name',
                'profile.last_name',
                'email:email',
                'profile.email_gravatar',
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
                        /** @var object $identity */
                        $identity = Yii::$app->user->identity;
                        if ($model->id !== $identity->id) {
                            return Html::a($model->statusLabelName, Url::to(['set-status', 'id' => $model->id]), [
                                    'id' => 'status-link-' . $model->id,
                                    'class' => 'link-status',
                                    'title' => Module::translate('module', 'Click to change the status'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'id' => $model->id,
                                    ],
                                ]) . ' '
                                . Html::a($model->labelMailConfirm, Url::to(
                                    [
                                        'send-confirm-email',
                                        'id' => $model->id
                                    ]
                                ), [
                                    'id' => 'email-link-' . $model->id,
                                    'class' => 'link-email',
                                    'title' => Module::translate(
                                        'module',
                                        'Send a link to activate your account.'
                                    ),
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
                    'value' => function ($model) {
                        $key = Html::tag('code', $model->auth_key, ['id' => 'authKey']);
                        $link = Html::a(
                            Module::translate('module', 'Generate'),
                            [
                                'generate-auth-key',
                                'id' => $model->id
                            ],
                            [
                                'class' => 'btn btn-sm btn-default',
                                'title' => Module::translate('module', 'Generate new key'),
                                'data' => [
                                    'toggle' => 'tooltip',
                                ],
                                'onclick' => "                                
                                $.ajax({
                                    type: 'POST',
                                    cache: false,
                                    url: this.href,
                                    success: function(response) {                                       
                                        if(response.success) {
                                            $('#authKey').html(response.success);
                                        }
                                    }
                                });
                                return false;
                            ",
                            ]
                        );
                        return $key . ' ' . $link;
                    }
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
                    'attribute' => 'profile.last_visit',
                    'format' => 'raw',
                    'value' => Yii::$app->formatter->asDatetime(
                        $model->profile->last_visit,
                        'd LLL yyyy, H:mm:ss'
                    ),
                ],
            ],
        ]) ?>
    </div>

    <div class="col-sm-offset-2 col-sm-10">
        <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> '
            . Module::translate('module', 'Update'),
            ['update', 'id' => $model->id],
            [
                'class' => 'btn btn-primary',
            ]
        ) ?>

        <?= Html::a(
            '<span class="glyphicon glyphicon-trash"></span> '
            . Module::translate('module', 'Delete'),
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Module::translate('module', 'Are you sure you want to delete the record?'),
                    'method' => 'post',
                ],
            ]
        ) ?>
    </div>
</div>
