<?php

namespace modules\users\commands;

use modules\users\models\User;
use yii\console\Controller;
use yii\helpers\Console;
use Yii;

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
                Yii::info('Remove expired users ' . $user->username);
                $this->stdout(' OK', Console::FG_GREEN, Console::BOLD);
            } else {
                Yii::warning('Cannot remove expired users ' . $user->username);
                $this->stderr(' FAIL', Console::FG_RED, Console::BOLD);
            }
            $this->stdout(PHP_EOL);
        }

        $this->stdout('Done!', Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }
}
