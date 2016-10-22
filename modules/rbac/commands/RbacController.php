<?php

namespace modules\rbac\commands;

use Yii;
use yii\console\Controller;
use modules\rbac\models\Rbac as BackendRbac;
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

        // Правила
        $rule = new \modules\rbac\rules\AuthorRule; // Только свои посты
        $auth->add($rule);

        // Добавляем правило Можно редактировать только свои посты
        $updateOwnPost = $auth->createPermission(BackendRbac::RULE_UPDATE_OWN_POST);
        $updateOwnPost->description = Yii::t('app', 'Update own post');
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);
        // -------------------------- //

        // Разрешения для доступа к Backend
        $backend = $auth->createPermission(BackendRbac::PERMISSION_BACKEND);
        $backend->description = Yii::t('app', 'Backend');
        $auth->add($backend);
        // ------------------------- //

        // Разрешения для User Manager
        $userManager = $auth->createPermission(BackendRbac::PERMISSION_BACKEND_USER_MANAGER);
        $userManager->description = Yii::t('app', 'User Manager');
        $auth->add($userManager);

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
        $user = $auth->createRole(BackendRbac::ROLE_USER);
        $user->description = Yii::t('app', 'User');
        $auth->add($user);

        $moder = $auth->createRole(BackendRbac::ROLE_MODERATOR);
        $moder->description = Yii::t('app', 'Moderator');
        $auth->add($moder);

        $manager = $auth->createRole(BackendRbac::ROLE_MANAGER);
        $manager->description = Yii::t('app', 'Manager');
        $auth->add($manager);

        $admin = $auth->createRole(BackendRbac::ROLE_ADMINISTRATOR);
        $admin->description = Yii::t('app', 'Administrator');
        $auth->add($admin);
        // ------------------------ //

        // Привязываем правило к редактированию профиля
        // "updateOwnPost" will be post from "updatePost"
        //$auth->addChild($updateOwnPost, $backendPostUpdate); // Можно редактировать только свой профиль

        // Привязка прав Управление пользователями к праву User Manager
        $auth->addChild($userManager, $backendUserCreate);
        $auth->addChild($userManager, $backendUserUpdate);
        $auth->addChild($userManager, $backendUserView);
        $auth->addChild($userManager, $backendUserDelete);
        // ------------------------ //

        // Формируем роль Модератор
        $auth->addChild($moder, $backend); // Модератору разрешаем доступ к админке
        $auth->addChild($moder, $user); // Модератор наследует Пользователя
        // Формируем роль Manager
        $auth->addChild($manager, $moder); // Менеджер наследует модератора
        $auth->addChild($manager, $userManager); // Менеджеру разрешаем управление пользователями
        // Наследование для роли Admin (админу можно всё)
        $auth->addChild($admin, $manager); // Наследуем роль Manager
        // ------------------------ //

        $this->stdout(Console::convertEncoding(Yii::t('app', 'Done!')) . PHP_EOL);
    }
}
