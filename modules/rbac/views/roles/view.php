<?php

use yii\helpers\Html;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Role */
/* @var $role yii\rbac\Role[] */

$this->title = Module::translate('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>

<div class="rbac-roles-view">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::translate('module', 'View Role') ?>
                <small><?= Html::encode($model->name) ?></small>
            </h3>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>

            <div class="row">
                <div class="col-md-6">
                    <?= $this->renderFile('@modules/rbac/views/common/_detailView.php', ['model' => $role]) ?>
                </div>
                <div class="col-md-6">
                    <?php if ($roles = $model->getRolesByRole()) : ?>
                        <strong><?= Module::translate('module', 'Roles by role') ?></strong>
                        <ul>
                            <?php foreach ($roles as $key => $value) {
                                echo Html::tag('li', $value) . PHP_EOL;
                            } ?>
                        </ul>
                    <?php endif; ?>
                    <?php if ($permissions = $model->getPermissionsByRole()) : ?>
                        <strong><?= Module::translate('module', 'Permissions by role') ?></strong>
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
                <?= Html::a(
                    '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . Module::translate(
                        'module',
                        'Update'
                    ),
                    [
                        'update',
                        'id' => $model->name
                    ],
                    [
                        'class' => 'btn btn-primary'
                    ]
                ) ?>
                <?= Html::a(
                    '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . Module::translate(
                        'module',
                        'Delete'
                    ),
                    [
                        'delete',
                        'id' => $model->name
                    ],
                    [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Module::translate(
                                'module',
                                'Are you sure you want to delete the entry?'
                            ),
                            'method' => 'post'
                        ]
                    ]
                ) ?>
            </p>
        </div>
    </div>
</div>
