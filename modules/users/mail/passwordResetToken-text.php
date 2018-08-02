<?php

/**
 * @var $this yii\web\View
 * @var $user modules\users\models\User
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['users/default/reset-password', 'token' => $user->password_reset_token]);
?>

Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
