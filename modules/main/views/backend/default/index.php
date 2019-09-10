<?php

use yii\helpers\Url;
use modules\users\Module as UserModule;
use modules\rbac\Module as RbacModule;
use modules\rbac\models\Permission;
use modules\main\Module;

/* @var $this yii\web\View */

$this->title = Module::t('module', 'Home');
$this->params['title']['small'] = Module::t('module', 'Dashboard');
/** @var yii\web\User $user */
$user = Yii::$app->user;
?>

<section class="content main-backend-default-index">
    <div class="row">
        <?php if ($user->can(Permission::PERMISSION_MANAGER_USERS)) : ?>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= UserModule::t('module', 'Users') ?></h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="<?= Module::t('module', 'Collapse') ?>">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                    title="<?= Module::t('module', 'Remove') ?>">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <a class="btn btn-app" href="<?= Url::to(['/users/default/index']) ?>">
                            <i class="fa fa-users"></i> <?= UserModule::t('module', 'Users') ?>
                        </a>
                        <?php if ($user->can(Permission::PERMISSION_MANAGER_RBAC)) : ?>
                            <a class="btn btn-app" href="<?= Url::to(['/rbac/default/index']) ?>">
                                <i class="fa fa-unlock"></i> <?= RbacModule::t('module', 'RBAC') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
