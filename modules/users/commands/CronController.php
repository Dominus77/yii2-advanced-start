<?php

namespace modules\users\commands;

use Yii;
use console\components\helpers\Console;
use yii\console\Controller;
use modules\users\models\User;
use modules\users\Module;

/**
 * Console crontab actions
 */
class CronController extends Controller
{
    /**
     * @var \modules\users\Module
     */
    public $module;

    /**
     * Removes non-activated expired users
     */
    public function actionRemoveOverdue()
    {
        foreach (User::find()->overdue($this->module->emailConfirmTokenExpire)->each() as $user) {
            /** @var User $user */
            $this->stdout($user->username);
            if ($user->delete() !== false) {
                Yii::info(Module::t('module', 'Remove expired user {:Username}', [':Username' => $user->username]));
                $this->stdout(' OK', Console::FG_GREEN, Console::BOLD);
            } else {
                Yii::warning(Module::t('module', 'Cannot remove expired user {:Username}', [':Username' => $user->username]));
                $this->stderr(' FAIL', Console::FG_RED, Console::BOLD);
            }
            $this->stdout(PHP_EOL);
        }

        $this->stdout(Module::t('module', 'Done!'), Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }
}
