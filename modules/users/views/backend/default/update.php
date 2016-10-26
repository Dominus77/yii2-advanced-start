<?php

use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'TITLE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-default-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li  class="active"><a href="#profile" data-toggle="tab"><?= Module::t('backend', 'TITLE_PROFILE'); ?></a></li>
            <li><a href="#password" data-toggle="tab"><?= Module::t('backend', 'TITLE_PASSWORD'); ?></a></li>
            <li><a href="#photo" data-toggle="tab"><?= Module::t('backend', 'TITLE_PHOTO'); ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="profile">
                <?= $this->render('update/_profile', [
                    'model' => $model,
                ]); ?>
            </div>
            <div class="tab-pane" id="password">
                <?= $this->render('update/_password', [
                    'model' => $model,
                ]); ?>
            </div>
            <div class="tab-pane" id="photo">
                <?= $this->render('update/_photo', [
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>
