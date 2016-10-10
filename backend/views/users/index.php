<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

//use backend\assets\AdminLTE\Select2Asset;

//Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box">
        <?php Pjax::begin(['enablePushState' => false]); ?>
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Yii::t('app', 'All Users')) ?></h3>

            <div class="box-tools pull-right">

            </div>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="pull-right">
                <p>
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-block btn-success',
                        'data' => [
                            'toggle' => 'tooltip',
                            'original-title' => Yii::t('app', 'CREATE'),
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'id' => 'grid-users',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}", // {summary}\n{items}\n{pager}
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'username',
                        'filter' => Html::activeInput('text', $searchModel, 'username', ['class' => 'form-control', 'placeholder' => Yii::t('app', '- Input text -')]),
                        'label' => Yii::t('app', 'Users'),
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'email',
                        'filter' => Html::activeInput('text', $searchModel, 'email', ['class' => 'form-control', 'placeholder' => Yii::t('app', '- Input text -')]),
                        'format' => 'email'
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => Select2::widget([
                            'model' => $searchModel,
                            'attribute' => 'status',
                            'data' => $searchModel->statusesArray,
                            'language' => 'ru',
                            'theme' => Select2::THEME_DEFAULT,
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => Yii::t('app', '- All -')
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->statusLabelName;
                        },
                        'contentOptions' => [
                            'class' => 'title-column',
                            'style' => 'width:150px',
                        ],
                    ],
                    [
                        'attribute' => 'userRoleName',
                        'filter' => Select2::widget([
                            'model' => $searchModel,
                            'attribute' => 'userRoleName',
                            'data' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
                            'language' => 'ru',
                            'theme' => Select2::THEME_DEFAULT,
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => Yii::t('app', '- All -')
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
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
                        'format' => 'datetime',
                        'filter' => DatePicker::widget([
                            'language' => 'ru',
                            'model' => $searchModel,
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'options' => ['placeholder' => Yii::t('app', 'Start date')],
                            'options2' => ['placeholder' => Yii::t('app', 'End date')],
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                                'autoclose' => true,
                            ]
                        ])
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'class' => 'action-column'
                        ],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view', 'id' => $model->id]), [
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'original-title' => Yii::t('app', 'VIEW'),
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update', 'id' => $model->id]), [
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'original-title' => Yii::t('app', 'UPDATE'),
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['delete', 'id' => $model->id]), [
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'original-title' => Yii::t('app', 'DELETE'),
                                        'method' => 'post',
                                        'confirm' => Yii::t('app', 'CONFIRM_DELETE'),
                                    ]
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
