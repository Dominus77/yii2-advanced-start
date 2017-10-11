<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Permission */
/* @var $permission yii\rbac\Permission[] */

$this->title = Module::t('module', 'View');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="rbac-backend-permissions-view">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?>
                <small><?= Html::encode($model->name) ?></small>
            </h3>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <div class="row">
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $permission,
                        'attributes' => [
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
                                'attribute' => 'data',
                                'label' => Module::t('module', 'Data'),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'createdAt',
                                'label' => Module::t('module', 'Created'),
                                'format' => 'datetime',
                            ],
                            [
                                'attribute' => 'updatedAt',
                                'label' => Module::t('module', 'Updated'),
                                'format' => 'datetime',
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?php if ($permissions = $model->getPermissionChildren()) : ?>
                        <strong><?= Module::t('module', 'Permissions by role') ?></strong>
                        <ul>
                            <?php foreach ($permissions as $key => $value) {
                                echo Html::tag('li', $value) . PHP_EOL;
                            } ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <p>
                <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . Yii::t('app', 'UPDATE'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . Yii::t('app', 'DELETE'), ['delete', 'id' => $model->name], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'CONFIRM_DELETE'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</div>
