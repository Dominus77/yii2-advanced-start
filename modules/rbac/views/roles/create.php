<?php

use yii\helpers\Html;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Role */

$this->title = Module::translate('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::translate('module', 'Create');
?>

<div class="rbac-roles-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::translate('module', 'Create Role') ?></h3>
        </div>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton(
                    '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' . Module::translate(
                        'module',
                        'Create'
                    ),
                    [
                        'class' => 'btn btn-success', 'form' => 'form-role'
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>
