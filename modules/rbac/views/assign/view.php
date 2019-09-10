<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */
/* @var $assignModel modules\rbac\models\Assignment */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Assign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Html::encode($model->username);
?>

<div class="rbac-assign-view">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'View') ?>
                <small><?= Html::encode($model->username) ?></small>
            </h3>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>

            <div class="row">
                <div class="col-md-6">
                    <?php try {
                        echo DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'username',
                                    'label' => Module::t('module', 'User'),
                                    'format' => 'raw'
                                ],
                                [
                                    'attribute' => 'role',
                                    'label' => Module::t('module', 'Role'),
                                    'format' => 'raw',
                                    'value' => static function ($model) use ($assignModel) {
                                        return $assignModel->getRoleName($model->id);
                                    }
                                ]
                            ]
                        ]);
                    } catch (Exception $e) {
                        // Save log
                    } ?>
                </div>
                <div class="col-md-6">
                    <?php
                    /** @var string $role */
                    $role = $assignModel->getRoleUser($model->id);
                    $auth = Yii::$app->authManager;
                    if ($permissionsRole = $auth->getPermissionsByRole($role)) : ?>
                        <strong><?= Module::t('module', 'Permissions by role') ?></strong>
                        <ul>
                            <?php foreach ($permissionsRole as $value) {
                                echo Html::tag('li', $value->name . ' (' . $value->description . ')') . PHP_EOL;
                            } ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <p>
                <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . Module::t('module', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ' . Module::t('module', 'Revoke'), ['revoke', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Module::t('module', 'Do you really want to untie the user from the role?'),
                        'method' => 'post'
                    ]
                ]) ?>
            </p>
        </div>
    </div>
</div>
