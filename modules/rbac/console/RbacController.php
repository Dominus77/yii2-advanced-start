<?php

namespace modules\rbac\console;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use modules\rbac\components\RbacInit;

/**
 * Class RbacController
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 *
 * @package console\controllers
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        if(RbacInit::processInit()) {
            $this->stdout('Done!', Console::FG_GREEN, Console::BOLD);
            $this->stdout(PHP_EOL);
        } else {
            $this->stderr('FAIL', Console::FG_RED, Console::BOLD);
        }
    }
}