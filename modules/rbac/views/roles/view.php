<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Role */
/* @var $role yii\rbac\Role[] */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>

<div class="rbac-roles-view">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'View Role') ?>
                <small><?= Html::encode($model->name) ?></small>
            </h3>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>

            <div class="row">
                <div class="col-md-6">
                    <?php try {
                        echo DetailView::widget([
                            'model' => $role,
                            'attributes' => [
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
                                    'attribute' => 'data',
                                    'label' => Module::t('module', 'Data'),
                                    'format' => 'raw'
                                ],
                                [
                                    'attribute' => 'createdAt',
                                    'label' => Module::t('module', 'Created'),
                                    'format' => 'datetime'
                                ],
                                [
                                    'attribute' => 'updatedAt',
                                    'label' => Module::t('module', 'Updated'),
                                    'format' => 'datetime'
                                ]
                            ]
                        ]);
                    } catch (Exception $e) {
                        // Save log
                    } ?>
                </div>
                <div class="col-md-6">
                    <?php if ($roles = $model->getRolesByRole()) : ?>
                        <strong><?= Module::t('module', 'Roles by role') ?></strong>
                        <ul>
                            <?php foreach ($roles as $key => $value) {
                                echo Html::tag('li', $value) . PHP_EOL;
                            } ?>
                        </ul>
                    <?php endif; ?>
                    <?php if ($permissions = $model->getPermissionsByRole()) : ?>
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
                <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . Module::t('module', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . Module::t('module', 'Delete'), ['delete', 'id' => $model->name], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Module::t('module', 'Are you sure you want to delete the entry?'),
                        'method' => 'post'
                    ]
                ]) ?>
            </p>
        </div>
    </div>
</div>
