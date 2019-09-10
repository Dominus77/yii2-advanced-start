<?php

use yii\helpers\Html;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Permission */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Module::t('module', 'Update');
?>

<div class="rbac-permissions-update">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Update Permission') ?>
                <small><?= Html::encode($model->name) ?></small>
            </h3>
        </div>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' . Module::t('module', 'Save'), [
                    'class' => 'btn btn-primary', 'form' => 'form-permission'
                ]) ?>
            </div>
        </div>
    </div>
</div>
