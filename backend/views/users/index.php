<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\VarDumper;
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
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

            <div class="box-tools pull-right">
                <!--<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                    <i class="fa fa-times"></i></button>-->
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

                    'username',
                    'email:email',
                    [
                        'attribute' => 'status',
                        'filter' => Select2::widget([
                            'model' => $searchModel,
                            'attribute' => 'status',
                            'data' => $searchModel->statusesArray,
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
                        'attribute' => 'role',
                        'filter' => Select2::widget([
                            'model' => $searchModel,
                            'attribute' => 'role',
                            'data' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
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
                            return $data->userRole;
                        },
                        'contentOptions' => [
                            'style' => 'width:200px',
                        ],
                    ],
                    'last_visit:datetime',
                    // 'created_at',
                    // 'updated_at',

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
            <?php
            //$roleUser = Yii::$app->authManager->getRolesByUser(31);
            //$roleUser = Yii::$app->authManager->getAssignments(31);
            //$roleUser = Yii::$app->authManager->getRolesByUser(31);
            //VarDumper::dump($roleUser['user'], 10, 1);
            ?>
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
