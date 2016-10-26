<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use modules\users\Module;

$this->title = Module::t('frontend', 'TITLE_MY_PROFILE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-default-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                    <?= Html::encode($this->title) ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="profile">
                <?= $this->render('index/_profile', [
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>