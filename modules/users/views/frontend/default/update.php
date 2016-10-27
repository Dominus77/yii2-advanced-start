<?php

use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->title = Module::t('frontend', 'TITLE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('frontend', 'TITLE_MY_PROFILE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$tab_profile = 'tab-pane';
$li_profile = '';

$tab_password = 'tab-pane';
$li_password = '';

$tab_avatar = 'tab-pane';
$li_avatar = '';

$getUrl = Yii::$app->request->get('tab');
switch ($getUrl) {
    case "profile":
        $li_profile = 'class="active"';
        $tab_profile = 'active tab-pane';
        break;
    case "password":
        $li_password = 'class="active"';
        $tab_password = 'active tab-pane';
        break;
    case "avatar":
        $li_avatar = 'class="active"';
        $tab_avatar = 'active tab-pane';
        break;
    default:
        $li_profile = 'class="active"';
        $tab_profile = 'active tab-pane';
}
?>
<div class="users-default-update">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?= $li_profile; ?>><a href="#profile"
                                       data-toggle="tab"><?= Module::t('frontend', 'TITLE_PROFILE'); ?></a>
            </li>
            <li <?= $li_password; ?>><a href="#password"
                                        data-toggle="tab"><?= Module::t('frontend', 'TITLE_PASSWORD'); ?></a></li>
            <li <?= $li_avatar; ?>><a href="#photo" data-toggle="tab"><?= Module::t('frontend', 'TITLE_PHOTO'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="<?= $tab_profile; ?>" id="profile">
                <?= $this->render('update/_profile', [
                    'model' => $model,
                ]); ?>
            </div>
            <div class="<?= $tab_password; ?>" id="password">
                <?= $this->render('update/_password', [
                    'model' => $model,
                ]); ?>
            </div>
            <div class="<?= $tab_avatar; ?>" id="photo">
                <?= $this->render('update/_photo', [
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>
