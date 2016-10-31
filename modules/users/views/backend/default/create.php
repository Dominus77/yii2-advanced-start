<?php

use yii\helpers\Html;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'TITLE_USERS');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('backend', 'TITLE_CREATE_USER');
?>
<div class="users-backend-default-create">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('backend', 'TITLE_CREATE_USER'); ?></h3>
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
