<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\components\rbac\Rbac as BackendRbac;
use console\components\helpers\Console;

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
        // Удаляем все старые данные
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();
        // ------------------------- //

        // Разрешения для доступа к Backend
        $backend = $auth->createPermission(BackendRbac::PERMISSION_BACKEND);
        $backend->description = Yii::t('app', 'Backend');
        $auth->add($backend);
        // ------------------------- //

        // Разрешения для User Manager
        $backendUserCreate = $auth->createPermission(BackendRbac::PERMISSION_BACKEND_USER_CREATE);
        $backendUserCreate->description = Yii::t('app', 'Create User');
        $auth->add($backendUserCreate);

        $backendUserUpdate = $auth->createPermission(BackendRbac::PERMISSION_BACKEND_USER_UPDATE);
        $backendUserUpdate->description = Yii::t('app', 'Update User');
        $auth->add($backendUserUpdate);

        $backendUserView = $auth->createPermission(BackendRbac::PERMISSION_BACKEND_USER_VIEW);
        $backendUserView->description = Yii::t('app', 'View User');
        $auth->add($backendUserView);

        $backendUserDelete = $auth->createPermission(BackendRbac::PERMISSION_BACKEND_USER_DELETE);
        $backendUserDelete->description = Yii::t('app', 'Delete User');
        $auth->add($backendUserDelete);
        // ------------------------- //

        // Роли
        $userManager = $auth->createRole('userManager');
        $userManager->description = Yii::t('app', 'User Manager');
        $auth->add($userManager);

        $user = $auth->createRole('user');
        $user->description = Yii::t('app', 'User');
        $auth->add($user);

        $moder = $auth->createRole('moder');
        $moder->description = Yii::t('app', 'Moderator');
        $auth->add($moder);

        $manager = $auth->createRole('manager');
        $manager->description = Yii::t('app', 'Manager');
        $auth->add($manager);

        $admin = $auth->createRole('admin');
        $admin->description = Yii::t('app', 'Administrator');
        $auth->add($admin);
        // ------------------------ //

        // Привязка разрешений Управление пользователями к роли User Manager
        $auth->addChild($userManager, $backendUserCreate);
        $auth->addChild($userManager, $backendUserUpdate);
        $auth->addChild($userManager, $backendUserView);
        $auth->addChild($userManager, $backendUserDelete);
        // ------------------------ //

        // Привязка разрешений Backend
        $auth->addChild($moder, $backend); // к роли Manager
        // ------------------------ //

        // Наследование для роли Moder (Moder можно всё что можно User)
        $auth->addChild($moder, $user);
        // Наследование для роли Manager (Manager можно всё что можно Moder)
        $auth->addChild($manager, $moder);
        $auth->addChild($manager, $userManager); // Разрешаем Manager управление пользователями
        // Наследование для роли Admin (админу можно всё)
        $auth->addChild($admin, $manager); // Наследуем роль Manager
        // ------------------------ //

        $this->stdout(Console::convertEncoding(Yii::t('app', 'Done!')) . PHP_EOL);
    }
}
