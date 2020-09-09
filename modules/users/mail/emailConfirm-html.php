<?php

/**
 * @var $this yii\web\View
 * @var $user modules\users\models\User
 */

use yii\helpers\Html;
use modules\users\Module;

$confirmLink = Yii::$app->urlManager->hostInfo . '/email-confirm?token=' . $user->email_confirm_token;
?>
<div class="email-confirm">
    <p><?= Module::translate('mail', 'HELLO {username}', ['username' => $user->username]) ?>!</p>
    <p><?= Module::translate('mail', 'FOLLOW_TO_CONFIRM_EMAIL') ?>:</p>
    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
    <p><?= Module::translate('mail', 'IGNORE_IF_DO_NOT_REGISTER') ?></p>
</div>
