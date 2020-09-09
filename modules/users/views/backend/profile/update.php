<?php

use yii\bootstrap\Tabs;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $uploadFormModel modules\users\models\UploadForm
 * @var $passwordForm modules\users\models\UpdatePasswordForm
 */

$this->title = Module::translate('module', 'Update');
$this->params['breadcrumbs'][] = ['label' => Module::translate('module', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$items = [
    [
        'label' => Module::translate('module', 'Profile'),
        'content' => $this->render('tabs/_update_profile', [
            'model' => $model->profile
        ]),
        'options' => ['id' => 'profile', 'role' => 'tabpanel'],
        'active' => !Yii::$app->request->get('tab') || (Yii::$app->request->get('tab') === 'profile')
    ],
    [
        'label' => Module::translate('module', 'Password'),
        'content' => $this->render('tabs/_update_password', [
            'model' => $passwordForm
        ]),
        'options' => ['id' => 'password', 'role' => 'tabpanel'],
        'active' => Yii::$app->request->get('tab') === 'password'
    ],
    [
        'label' => Module::translate('module', 'Avatar'),
        'content' => $this->renderFile(Yii::getAlias('@modules/users/views/common/profile/tabs/_update_avatar.php'), [
            'model' => $model,
            'uploadFormModel' => $uploadFormModel
        ]),
        'options' => ['id' => 'avatar', 'role' => 'tabpanel'],
        'active' => Yii::$app->request->get('tab') === 'avatar'
    ]
];
?>

<div class="users-backend-profile-update">
    <div class="nav-tabs-custom">
        <?= Tabs::widget([
            'options' => ['role' => 'tablist'],
            'items' => $items
        ]) ?>
    </div>
</div>
