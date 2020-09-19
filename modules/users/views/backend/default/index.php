<?php

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use backend\assets\plugins\DatePickerAsset;
use modules\rbac\models\Assignment;
use modules\users\models\User;
use modules\users\assets\UserAsset;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $searchModel modules\users\models\search\UserSearch
 * @var $model modules\users\models\User
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $assignModel Assignment
 */

$this->title = Module::translate('module', 'Users');
$this->params['breadcrumbs'][] = $this->title;

UserAsset::register($this);

$language = substr(Yii::$app->language, 0, 2);
DatePickerAsset::$language = $language;
DatePickerAsset::register($this);

$js = new JsExpression("
    initDatePicker();
    $(document).on('ready pjax:success', function() {
       initDatePicker();
    });

    function initDatePicker()
    {
        /** @see http://bootstrap-datepicker.readthedocs.io/en/latest/index.html */
        $('#datepicker').bootstrapDP({
            language: '{$language}',
            autoclose: true,
            format: 'dd.mm.yyyy',
            zIndexOffset: 1001,
            orientation: 'bottom',
            todayHighlight: true
        });
    }
");
$this->registerJs($js, View::POS_END);

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
                <?= common\widgets\PageSize::widget([
                    'label' => '',
                    'defaultPageSize' => 25,
                    'sizes' => [10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 200 => 200],
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]) ?>
            </div>
            <div class="pull-right">
                <p>
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-block btn-success',
                        'title' => Module::translate('module', 'Create'),
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
                'filterSelector' => 'select[name="per-page"]',
                'layout' => "{items}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => SerialColumn::class],
                    [
                        'attribute' => 'username',
                        'filter' => Html::activeInput('text', $searchModel, 'username', [
                            'class' => 'form-control',
                            'placeholder' => Module::translate('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'label' => Module::translate('module', 'Users'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            $view = Yii::$app->controller->view;
                            return $view->render('_avatar_column', ['model' => $data]);
                        },
                        'headerOptions' => ['width' => '120'],
                    ],
                    [
                        'attribute' => 'email',
                        'filter' => Html::activeInput('text', $searchModel, 'email', [
                            'class' => 'form-control',
                            'placeholder' => Module::translate('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'email'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'status',
                            $searchModel->statusesArray,
                            [
                                'class' => 'form-control',
                                'prompt' => Module::translate('module', '- all -'),
                                'data' => [
                                    'pjax' => true,
                                ],
                            ]
                        ),
                        'format' => 'raw',
                        'value' => static function ($data) {
                            /** @var object $identity */
                            $identity = Yii::$app->user->identity;
                            /** @var User $data */
                            if ($data->id !== $identity->id && !$data->isSuperAdmin($data->id)) {
                                return Html::a($data->statusLabelName, Url::to(['set-status', 'id' => $data->id]), [
                                        'id' => $data->id,
                                        'class' => 'link-status',
                                        'title' => Module::translate('module', 'Click to change the status'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'pjax' => 0,
                                            'id' => $data->id,
                                        ],
                                    ]) . ' ' .
                                    Html::a(
                                        $data->labelMailConfirm,
                                        Url::to(
                                            [
                                                'send-confirm-email',
                                                'id' => $data->id
                                            ]
                                        ),
                                        [
                                            'id' => 'email-link-' . $data->id,
                                            'class' => 'link-email',
                                            'title' => Module::translate(
                                                'module',
                                                'Send a link to activate your account.'
                                            ),
                                            'data' => [
                                                'toggle' => 'tooltip',
                                            ],
                                        ]
                                    );
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
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'userRoleName',
                            $assignModel->getRolesArray(),
                            [
                                'class' => 'form-control',
                                'prompt' => Module::translate('module', '- all -'),
                                'data' => [
                                    'pjax' => true,
                                ],
                            ]
                        ),
                        'format' => 'raw',
                        'value' => function ($data) use ($assignModel) {
                            return $assignModel->getUserRoleName($data->id);
                        },
                        'contentOptions' => [
                            'style' => 'width:200px',
                        ],
                    ],
                    [
                        'attribute' => 'profile.last_visit',
                        'filter' => '<div class="form-group"><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>' // phpcs:ignore
                            . Html::activeInput('text', $searchModel, 'date_from', [
                                'id' => 'datepicker',
                                'class' => 'form-control',
                                'placeholder' => Module::translate('module', '- select -'),
                                'data' => [
                                    'pjax' => true,
                                ],
                            ]) . '</div></div>',
                        'format' => 'datetime',
                        'headerOptions' => [
                            'style' => 'width: 165px;'
                        ]
                    ],
                    [
                        'class' => ActionColumn::class,
                        'contentOptions' => [
                            'class' => 'action-column'
                        ],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>',
                                    $url,
                                    [
                                        'title' => Module::translate('module', 'View'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'pjax' => 0,
                                        ]
                                    ]
                                );
                            },
                            'update' => function ($url) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Module::translate('module', 'Update'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                $linkOptions = [
                                    'title' => Module::translate('module', 'Delete'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'method' => 'post',
                                        'pjax' => 0,
                                        'confirm' => Module::translate(
                                            'module',
                                            'The user "{:name}" will be marked as deleted!',
                                            [
                                                ':name' => $model->username
                                            ]
                                        ),
                                    ]
                                ];
                                /* @var $model User */
                                if ($model->isDeleted()) {
                                    $linkOptions = [
                                        'title' => Module::translate('module', 'Delete'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'method' => 'post',
                                            'pjax' => 0,
                                            'confirm' => Module::translate(
                                                'module',
                                                'You won\'t be able to revert this!'
                                            ),
                                        ],
                                    ];
                                }
                                return Html::a(
                                    '<span class="glyphicon glyphicon-trash"></span>',
                                    $url,
                                    $linkOptions
                                );
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
