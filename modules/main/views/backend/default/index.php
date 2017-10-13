<?php

use yii\helpers\Html;
use yii\helpers\Url;
use modules\main\Module;

/* @var $this yii\web\View */

$this->title = Module::t('backend', 'TITLE_HOME');
$this->params['title']['small'] = Module::t('backend', 'TITLE_DASHBOARD');
?>
<section class="content main-backend-default-index">
    <div class="row">

        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Users') ?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="<?= Module::t('backend', 'BUTTON_COLLAPSE'); ?>">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="<?= Module::t('backend', 'BUTTON_REMOVE'); ?>">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <a class="btn btn-app" href="<?= Url::to(['/users/default/index']); ?>">
                        <i class="fa fa-users"></i> <?= Yii::t('app', 'Users'); ?>
                    </a>
                    <?php if (\Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_MANAGER_RBAC)) : ?>
                        <a class="btn btn-app" href="<?= Url::to(['/rbac/default/index']); ?>">
                            <i class="fa fa-unlock"></i> <?= Yii::t('app', 'RBAC'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>
