<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
use modules\rbac\Module;

/** @var $id string */
/** @var $dataProvider ActiveDataProvider */

echo GridView::widget([
    'id' => $id,
    'dataProvider' => $dataProvider,
    'filterSelector' => 'select[name="per-page"]',
    'layout' => '{items}',
    'tableOptions' => [
        'class' => 'table table-bordered table-hover'
    ],
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'attribute' => 'name',
            'label' => Module::translate('module', 'Name'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'description',
            'label' => Module::translate('module', 'Description'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'ruleName',
            'label' => Module::translate('module', 'Rule Name'),
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
                        'title' => Module::translate('module', 'View'),
                        'data' => [
                            'toggle' => 'tooltip'
                        ]
                    ]);
                },
                'update' => static function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        'title' => Module::translate('module', 'Update'),
                        'data' => [
                            'toggle' => 'tooltip'
                        ]
                    ]);
                },
                'delete' => static function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Module::translate('module', 'Delete'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'method' => 'post',
                            'confirm' => Module::translate('module', 'Are you sure you want to delete the entry?')
                        ]
                    ]);
                }
            ]
        ]
    ]
]);
