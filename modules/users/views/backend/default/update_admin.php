<?php

use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('module', 'Update');
$this->params['title']['small'] = $model->username;

$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('module', 'Update');
?>

<div class="users-backend-default-update">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Update'); ?></h3>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
