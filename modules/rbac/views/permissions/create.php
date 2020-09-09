<?php

use yii\helpers\Html;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Permission */

$this->title = Module::translate('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::translate('module', 'Create');
?>

<div class="rbac-permissions-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::translate('module', 'Create Permission') ?></h3>
        </div>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> ' . Module::translate(
                    'module',
                    'Create'
                ), [
                    'class' => 'btn btn-success', 'form' => 'form-permission'
                ]) ?>
            </div>
        </div>
    </div>
</div>
