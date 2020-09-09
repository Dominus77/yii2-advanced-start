<?php

/**
 * @var $this yii\web\View
 * @var $user modules\users\models\User
 */

use modules\users\Module;

$confirmLink = Yii::$app->urlManager->hostInfo . '/email-confirm?token=' . $user->email_confirm_token;
?>

<?= Module::translate('mail', 'HELLO {username}', ['username' => $user->username]); ?>!

<?= Module::translate('mail', 'FOLLOW_TO_CONFIRM_EMAIL') ?>:

<?= $confirmLink ?>

<?= Module::translate('mail', 'IGNORE_IF_DO_NOT_REGISTER') ?>
