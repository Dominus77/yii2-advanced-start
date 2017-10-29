<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Roles');
?>
<div class="rbac-backend-roles-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Roles') ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right">
                <p>
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-block btn-success',
                        'title' => Module::t('module', 'Create Role'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'left',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'label' => Module::t('module', 'Name'),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'description',
                        'label' => Module::t('module', 'Description'),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'ruleName',
                        'label' => Module::t('module', 'Rule Name'),
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'class' => 'action-column'
                        ],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view', 'id' => $model->name]), [
                                    'title' => Module::t('module', 'View'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update', 'id' => $model->name]), [
                                    'title' => Module::t('module', 'Update'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['delete', 'id' => $model->name]), [
                                    'title' => Module::t('module', 'Delete'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'method' => 'post',
                                        'confirm' => Module::t('module', 'Are you sure you want to delete the entry?'),
                                    ]
                                ]);

                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
