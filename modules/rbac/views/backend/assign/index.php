<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dominus77\sweetalert2\assets\SweetAlert2Asset;
use modules\rbac\Module;

SweetAlert2Asset::register($this);

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Assign');

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
<div class="rbac-backend-assign-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Assign') ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
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
                        'template' => '{view} {update} {revoke}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view', 'id' => $model->id]), [
                                    'title' => Module::t('module', 'View'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update', 'id' => $model->id]), [
                                    'title' => Module::t('module', 'Update'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'revoke' => function ($url, $model) {
                                $linkOptions = [];
                                if ($model->id == Yii::$app->user->identity->getId()) {
                                    $linkOptions = [
                                        'style' => 'display: none;',
                                    ];
                                }
                                if ($model->status == $model::STATUS_DELETED) {
                                    $linkOptions = ArrayHelper::merge([
                                        'class' => 'text-danger',
                                    ], $linkOptions);
                                }
                                $options = json_encode([
                                    'title' => Module::t('module', 'Are you sure?'),
                                    'text' => Module::t('module', 'User "{:username}" will be unlinked from "{:role}"!', [
                                        ':username' => $model->username,
                                        ':role' => $model->getRoleName($model->id),
                                    ]),
                                    'confirmButtonText' => Module::t('module', 'Yes, untie it!'),
                                    'cancelButtonText' => Module::t('module', 'No, do not untie'),
                                    'url' => Url::to(['revoke', 'id' => $model->id]),
                                ]);
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', ArrayHelper::merge([
                                    'title' => Module::t('module', 'Revoke'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ],
                                    'onclick' => "confirm({$options}); return false;",
                                ], $linkOptions));
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
