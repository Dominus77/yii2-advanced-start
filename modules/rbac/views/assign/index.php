<?php

use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use modules\rbac\models\Assignment;
use modules\rbac\Module;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $assignModel Assignment */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Assign');
?>

<div class="rbac-assign-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Assign') ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
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
            <div class="pull-right"></div>
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => '{items}',
                    'tableOptions' => [
                        'class' => 'table table-bordered table-hover'
                    ],
                    'columns' => [
                        ['class' => SerialColumn::class],
                        [
                            'attribute' => 'username',
                            'label' => Module::t('module', 'User'),
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'role',
                            'label' => Module::t('module', 'Role'),
                            'format' => 'raw',
                            'value' => static function ($data) use ($assignModel) {
                                return $assignModel->getRoleName($data->id);
                            }
                        ],
                        [
                            'class' => ActionColumn::class,
                            'urlCreator' => static function ($action, $model) {
                                return Url::to([$action, 'id' => $model->id]);
                            },
                            'contentOptions' => [
                                'class' => 'action-column'
                            ],
                            'template' => '{view} {update} {revoke}',
                            'buttons' => [
                                'view' => static function ($url) {
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Module::t('module', 'View'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'pjax' => 0
                                        ]
                                    ]);
                                },
                                'update' => static function ($url) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Module::t('module', 'Update'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'pjax' => 0
                                        ]
                                    ]);
                                },
                                'revoke' => static function ($url, $model) {
                                    $linkOptions = [];
                                    /** @var object $identity */
                                    $identity = Yii::$app->user->identity;
                                    if ($model->id === $identity->id) {
                                        $linkOptions = [
                                            'style' => 'display: none;'
                                        ];
                                    }
                                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, ArrayHelper::merge([
                                        'title' => Module::t('module', 'Revoke'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'method' => 'post',
                                            'confirm' => Module::t('module', 'Do you really want to untie the user from the role?')
                                        ]
                                    ], $linkOptions));
                                }
                            ]
                        ]
                    ]
                ]) ?>
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
    </div>
</div>
