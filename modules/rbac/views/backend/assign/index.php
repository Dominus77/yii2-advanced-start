<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Assign');
?>
<div class="rbac-backend-assign-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Assign') ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'username',
                        'label' => Module::t('module', 'User'),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'role',
                        'label' => Module::t('module', 'Role'),
                        'format' => 'raw',
                        'value' => function ($data) {
                            /** @var $data \modules\rbac\models\Assignment */
                            return $data->getRoleName($data->id);
                        }
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
                                        'original-title' => Module::t('module', 'View'),
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update', 'id' => $model->id]), [
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'original-title' => Module::t('module', 'Update'),
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                $linkOptions = [];
                                if ($model->id == Yii::$app->user->identity->getId()) {
                                    $linkOptions = [
                                        'style' => 'display: none;',
                                    ];
                                }
                                if ($model->status == $model::STATUS_DELETED) {
                                    $linkOptions = ArrayHelper::merge([
                                        'class' => 'text-danger',
                                        'data' => [
                                            'confirm' => Module::t('module', 'The element will be irrevocably removed, which may affect some data. Do you really want to delete it?'),
                                        ]
                                    ], $linkOptions);
                                }
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['delete', 'id' => $model->id]), ArrayHelper::merge([
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'original-title' => Module::t('module', 'Delete'),
                                        'method' => 'post',
                                        'confirm' => Module::t('module', 'Are you sure you want to delete this item?'),
                                    ]
                                ], $linkOptions));
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
