<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use modules\rbac\Module;

SweetAlert2Asset::register($this);

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Roles');

$canceled = json_encode([
    'title' => Module::t('module', 'Cancelled!'),
    'text' => Module::t('module', 'Uninstall action canceled.'),
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
            <?php Pjax::begin([
                'id' => 'pjax-container',
                'enablePushState' => false,
                'timeout' => 5000,
            ]); ?>
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
                                $options = json_encode([
                                    'title' => Module::t('module', 'Are you sure?'),
                                    'text' => Module::t('module', 'The role "{:name}" will deleted!', [':name' => $model->name]),
                                    'confirmButtonText' => Module::t('module', 'Yes, delete it!'),
                                    'cancelButtonText' => Module::t('module', 'No, do not delete'),
                                    'url' => $url,
                                ]);
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
            <?php Pjax::end(); ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
