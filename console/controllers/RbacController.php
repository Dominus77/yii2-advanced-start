<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\components\rbac\Rbac as BackendRbac;

/**
 * Console RBAC
 *
 * @package console\controllers
 * input root app console: php yii rbac/init
 */
class RbacController extends Controller
{
    /**
     * Generates roles
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $backend = $auth->createPermission(BackendRbac::PERMISSION_BACKEND);
        $backend->description = 'Backend';
        $auth->add($backend);

        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $auth->addChild($admin, $user);
        $auth->addChild($admin, $backend);

        $this->stdout('Done!' . PHP_EOL);
    }
}
