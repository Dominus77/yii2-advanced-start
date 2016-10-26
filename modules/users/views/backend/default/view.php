<?php

use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('backend', 'TITLE_VIEW_USER');
$this->params['breadcrumbs'][] = ['label' => Module::t('backend', 'TITLE_USERS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-default-view">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#profile" data-toggle="tab"><?= Module::t('backend', 'TITLE_PROFILE'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="profile">
                <?= $this->render('view/_profile', [
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>
