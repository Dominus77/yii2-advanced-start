<?php

use yii\helpers\Html;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Assignment */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Assign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->user->id]];
$this->params['breadcrumbs'][] = Module::t('module', 'Update');
?>

<div class="rbac-assign-update">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Update') ?>
                <small><?= Html::encode($model->user->username) ?></small>
            </h3>
        </div>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
