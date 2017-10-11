<?php

use yii\helpers\Html;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Permission */

$this->title = Module::t('module', 'Create');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-backend-permissions-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'CREATE'), ['class' => 'btn btn-success', 'form' => 'form-permission']) ?>
            </div>
        </div>
    </div>
</div>
