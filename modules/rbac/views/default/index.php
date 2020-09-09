<?php

use yii\helpers\Html;
use yii\helpers\Url;
use modules\rbac\Module;

/* @var $this yii\web\View */

$this->title = Module::translate('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = Module::translate('module', 'RBAC');
?>

<div class="rbac-default-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::translate('module', 'RBAC') ?></h3>

            <div class="box-tools pull-right">

            </div>
        </div>
        <div class="box-body">
            <ul>
                <li>
                    <a href="<?= Url::to(['permissions/index']) ?>">
                        <?= Module::translate('module', 'Permissions') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['roles/index']) ?>">
                        <?= Module::translate('module', 'Roles') ?>
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(['assign/index']) ?>">
                        <?= Module::translate(
                            'module',
                            'Assign rights'
                        ) ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <?= Html::a('<span class="glyphicon glyphicon-repeat"></span>', Url::to(['init']), [
                    'class' => 'text-yellow',
                    'data' => [
                        'toggle' => 'tooltip',
                        'original-title' => Module::translate(
                            'module',
                            'Reset rbac'
                        ),
                        'method' => 'post',
                        'confirm' => Module::translate(
                            'module',
                            'Attention! All previously created permissions and roles will be deleted. Do you really want to perform this action?' // phpcs:ignore
                        )
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>
