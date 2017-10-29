<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use modules\users\Module;

SweetAlert2Asset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel modules\users\models\backend\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Users');
$this->params['breadcrumbs'][] = $this->title;

$canceled = json_encode([
    'title' => Module::t('module', 'Cancelled!'),
    'text' => Module::t('module', 'The action to remove the user has been canceled.'),
    'type' => 'error',
]);
$script = new \yii\web\JsExpression("
    function confirm(options) {
        var title = options.title,
            text = options.text,
            confirmButtonText = options.confirmButtonText,
            cancelButtonText = options.cancelButtonText,
            url = options.url;

        swal({
            title: title,
            text: text,
            type: 'warning',
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText
        }).then(function () {
            $.post(url).done(function (data) {
                swal({
                    title: data.title,
                    text: data.text,
                    type: data.type
                });
                $.pjax.reload({container: '#pjax-container', timeout: 5000});
            })
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal({$canceled})
            }
        });
    }

    $(document).on('ready pjax:success', function() {
        $(\"[data-toggle='tooltip']\").tooltip();
    });
");

$this->registerJs($script, \yii\web\View::POS_END);
?>
<div class="users-backend-default-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

            <div class="box-tools pull-right">

            </div>
        </div>
        <?php Pjax::begin([
            'id' => 'pjax-container',
            'enablePushState' => false,
            'timeout' => 5000,
        ]); ?>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
                            return $this->render('avatar_column', ['model' => $data]);
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
                            if ($data->id != Yii::$app->user->identity->getId()) {
                                $this->registerJs("$('#status_link_" . $data->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
                                return Html::a($data->statusLabelName, Url::to(['status', 'id' => $data->id]), [
                                    'id' => 'status_link_' . $data->id,
                                    'title' => Module::t('module', 'Click to change status'),
                                    'data' => [
                                        'pjax' => 0,
                                        'toggle' => 'tooltip',
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
                        'attribute' => 'userRoleName',
                        'filter' => Html::activeDropDownList($searchModel, 'userRoleName', $searchModel->rolesArray, [
                            'class' => 'form-control',
                            'prompt' => Module::t('module', '- all -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->userRoleName;
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
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Module::t('module', 'View'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Module::t('module', 'Update'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if ($model->isDeleted()) {
                                    $options = json_encode([
                                        'title' => Module::t('module', 'Are you sure?'),
                                        'text' => Module::t('module', 'You won\'t be able to revert this!'),
                                        'confirmButtonText' => Module::t('module', 'Yes, delete it!'),
                                        'cancelButtonText' => Module::t('module', 'No, do not delete'),
                                        'url' => $url,
                                    ]);
                                } else {
                                    $options = json_encode([
                                        'title' => Module::t('module', 'Are you sure?'),
                                        'text' => Module::t('module', 'The user "{:name}" will be marked as deleted!', [':name' => $model->username]),
                                        'confirmButtonText' => Module::t('module', 'Yes, note!'),
                                        'cancelButtonText' => Module::t('module', 'No, do not tag.'),
                                        'url' => $url,
                                    ]);
                                }
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                                    'title' => Module::t('module', 'Delete'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ],
                                    'onclick' => "confirm({$options}); return false;",
                                ]);
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
