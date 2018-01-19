<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\users\models\search\UserSearch */
/* @var $model modules\users\models\User */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $assignModel \modules\rbac\models\Assignment */

$this->title = Module::t('module', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-backend-default-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <?php Pjax::begin([
            'id' => 'pjax-container',
            'enablePushState' => false,
            'timeout' => 5000,
        ]); ?>
        <div class="box-body">
            <div class="pull-left">
                <?= $this->render('_pageSize', [
                    'model' => $searchModel,
                ]) ?>
            </div>
            <div class="pull-right">
                <p>
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-block btn-success',
                        'title' => Module::t('module', 'Create'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'left',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'id' => 'grid-users',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}", // {summary}\n{sorter}\n{items}\n{pager}
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'username',
                        'filter' => Html::activeInput('text', $searchModel, 'username', [
                            'class' => 'form-control',
                            'placeholder' => Module::t('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'label' => Module::t('module', 'Users'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $this->render('_avatar_column', ['model' => $data]);
                        },
                        'headerOptions' => ['width' => '120'],
                    ],
                    [
                        'attribute' => 'email',
                        'filter' => Html::activeInput('text', $searchModel, 'email', [
                            'class' => 'form-control',
                            'placeholder' => Module::t('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'email'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusesArray, [
                            'class' => 'form-control',
                            'prompt' => Module::t('module', '- all -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) {
                            /** @var modules\users\models\User $identity */
                            $identity = Yii::$app->user->identity;
                            if ($data->id != $identity->id) {
                                $this->registerJs("$('#status_link_" . $data->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
                                return Html::a($data->statusLabelName, Url::to(['status', 'id' => $data->id]), [
                                    'id' => 'status_link_' . $data->id,
                                    'title' => Module::t('module', 'Click to change the status'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ],
                                ]);
                            }
                            return $data->statusLabelName;
                        },
                        'headerOptions' => [
                            'class' => 'text-center',
                        ],
                        'contentOptions' => [
                            'class' => 'title-column',
                            'style' => 'width:150px',
                        ],
                    ],
                    [
                        'attribute' => 'Role',
                        'filter' => Html::activeDropDownList($searchModel, 'userRoleName', $assignModel->getRolesArray(), [
                            'class' => 'form-control',
                            'prompt' => Module::t('module', '- all -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) use ($assignModel) {
                            return $assignModel->getUserRoleName($data->id);
                        },
                        'contentOptions' => [
                            'style' => 'width:200px',
                        ],
                    ],
                    [
                        'attribute' => 'last_visit',
                        'format' => 'raw',
                        'filter' => DatePicker::widget([
                            'language' => Yii::$app->language,
                            'model' => $searchModel,
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'options' => ['placeholder' => Module::t('module', '- start -')],
                            'options2' => ['placeholder' => Module::t('module', '- end -')],
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'format' => 'dd-mm-yyyy',
                                'autoclose' => true,
                            ]
                        ]),
                        'value' => function ($data) {
                            return Yii::$app->formatter->asDatetime($data->last_visit, 'd LLL yyyy, H:mm');
                        },
                        'headerOptions' => [
                            'class' => 'text-center',
                        ],
                        'contentOptions' => [
                            'class' => 'text-center',
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'class' => 'action-column'
                        ],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Module::t('module', 'View'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Module::t('module', 'Update'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                $linkOptions = [
                                    'title' => Module::t('module', 'Delete'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'method' => 'post',
                                        'pjax' => 0,
                                        'confirm' => Module::t('module', 'The user "{:name}" will be marked as deleted!', [':name' => $model->username]),
                                    ]
                                ];
                                /* @var $model modules\users\models\User */
                                if ($model->isDeleted()) {
                                    $linkOptions = [
                                        'title' => Module::t('module', 'Delete'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'method' => 'post',
                                            'pjax' => 0,
                                            'confirm' => Module::t('module', 'You won\'t be able to revert this!'),
                                        ],
                                    ];
                                }
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $linkOptions);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
        <div class="box-footer">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'registerLinkTags' => true,
                'options' => [
                    'class' => 'pagination pagination-sm no-margin pull-right',
                ]
            ]) ?>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>
