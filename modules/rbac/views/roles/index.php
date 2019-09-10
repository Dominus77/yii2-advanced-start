<?php

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Roles');
?>

<div class="rbac-roles-index">
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
                            'placement' => 'left'
                        ]
                    ]) ?>
                </p>
            </div>
            <?php try {
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{items}',
                    'tableOptions' => [
                        'class' => 'table table-bordered table-hover'
                    ],
                    'columns' => [
                        ['class' => SerialColumn::class],
                        [
                            'attribute' => 'name',
                            'label' => Module::t('module', 'Name'),
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'description',
                            'label' => Module::t('module', 'Description'),
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'ruleName',
                            'label' => Module::t('module', 'Rule Name'),
                            'format' => 'raw'
                        ],
                        [
                            'class' => ActionColumn::class,
                            'contentOptions' => [
                                'class' => 'action-column'
                            ],
                            'template' => '{view} {update} {delete}',
                            'buttons' => [
                                'view' => static function ($url) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Module::t('module', 'View'),
                                        'data' => [
                                            'toggle' => 'tooltip'
                                        ]
                                    ]);
                                },
                                'update' => static function ($url) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Module::t('module', 'Update'),
                                        'data' => [
                                            'toggle' => 'tooltip'
                                        ]
                                    ]);
                                },
                                'delete' => static function ($url) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Module::t('module', 'Delete'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'method' => 'post',
                                            'confirm' => Module::t('module', 'Are you sure you want to delete the entry?')
                                        ]
                                    ]);
                                }
                            ]
                        ]
                    ]
                ]);
            } catch (Exception $e) {
                // Save log
            } ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
