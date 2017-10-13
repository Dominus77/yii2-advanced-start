<?php

use yii\helpers\Html;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'Users');
$this->params['title']['small'] = Module::t('backend', 'Create');

$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('backend', 'Create');
?>
<div class="users-backend-default-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('backend', 'Create'); ?></h3>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
