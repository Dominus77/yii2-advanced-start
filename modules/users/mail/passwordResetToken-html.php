<?php

/**
 * @var $this yii\web\View
 * @var $user modules\users\models\User
 */

use yii\helpers\Html;
use modules\users\Module;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['users/default/reset-password', 'token' => $user->password_reset_token]);
?>

<div class="password-reset">
    <p><?= Module::t('mail', 'HELLO {username}', ['username' => $user->username]); ?>,</p>
    <p><?= Module::t('mail', 'FOLLOW_TO_RESET_PASSWORD') ?>:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
