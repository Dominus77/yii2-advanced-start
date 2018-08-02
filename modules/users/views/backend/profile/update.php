<?php

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $passwordForm modules\users\models\UpdatePasswordForm
 */

use modules\users\Module;
use yii\bootstrap\Tabs;

$this->title = Module::t('module', 'Update');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-backend-profile-update">
    <div class="nav-tabs-custom">
        <?= Tabs::widget([
            'options' => ['role' => 'tablist'],
            'items' => [
                [
                    'label' => Module::t('module', 'Profile'),
                    'content' => $this->render('tabs/_update_profile', [
                        'model' => $model->profile,
                    ]),
                    'options' => ['id' => 'profile', 'role' => 'tabpanel'],
                    'active' => (!Yii::$app->request->get('tab') || (Yii::$app->request->get('tab') == 'profile')) ? true : false,
                ],
                [
                    'label' => Module::t('module', 'Password'),
                    'content' => $this->render('tabs/_update_password', [
                        'model' => $passwordForm,
                    ]),
                    'options' => ['id' => 'password', 'role' => 'tabpanel'],
                    'active' => (Yii::$app->request->get('tab') == 'password') ? true : false,
                ],
                [
                    'label' => Module::t('module', 'Avatar'),
                    'content' => $this->renderFile(Yii::getAlias('@modules/users/views/common/profile/tabs/_update_avatar.php'), [
                        'model' => $model,
                    ]),
                    'options' => ['id' => 'avatar', 'role' => 'tabpanel'],
                    'active' => (Yii::$app->request->get('tab') == 'avatar') ? true : false,
                ],
            ]
        ]); ?>
    </div>
</div>
