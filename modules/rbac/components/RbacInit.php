<?php

namespace modules\rbac\components;

use Yii;
use modules\rbac\models\Role;
use modules\rbac\models\Permission;

/**
 * Class RbacInit
 * @package modules\rbac\components
 */
class RbacInit
{
    public static function processInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли, по умолчанию для новых авторизованных пользователей, default
        $super_admin = $auth->createRole(Role::ROLE_SUPER_ADMIN);
        $super_admin->description = Role::ROLE_SUPER_ADMIN_DESCRIPTION;

        $admin = $auth->createRole(Role::ROLE_ADMIN);
        $admin->description = Role::ROLE_ADMIN_DESCRIPTION;

        $manager = $auth->createRole(Role::ROLE_MANAGER);
        $manager->description = Role::ROLE_MANAGER_DESCRIPTION;

        $editor = $auth->createRole(Role::ROLE_EDITOR);
        $editor->description = Role::ROLE_EDITOR_DESCRIPTION;

        $default = $auth->createRole(Role::ROLE_DEFAULT);
        $default->description = Role::ROLE_DEFAULT_DESCRIPTION;

        // запишем их в БД
        $auth->add($super_admin);
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($editor);
        $auth->add($default);

        // Создаем наше правило, которое позволит проверить автора по полю author_id
        $authorRule = new \modules\rbac\components\AuthorRule;

        // Запишем их в БД
        $auth->add($authorRule);

        /**
         * Создаем разрешения.
         */
        // Доступ к админке
        $viewAdminPage = $auth->createPermission(Permission::PERMISSION_VIEW_ADMIN_PAGE);
        $viewAdminPage->description = Permission::PERMISSION_VIEW_ADMIN_PAGE_DESCRIPTION;

        // Управление RBAC
        $managerRbac = $auth->createPermission(Permission::PERMISSION_MANAGER_RBAC);
        $managerRbac->description = Permission::PERMISSION_MANAGER_RBAC_DESCRIPTION;

        // Пользователи
        $managerUsers = $auth->createPermission(Permission::PERMISSION_MANAGER_USERS);
        $managerUsers->description = Permission::PERMISSION_MANAGER_USERS_DESCRIPTION;

        // Посты
        $managerPosts = $auth->createPermission(Permission::PERMISSION_MANAGER_POST);
        $managerPosts->description = Permission::PERMISSION_MANAGER_POST_DESCRIPTION;

        // Создадим еще новое разрешение «Редактирование собственного поста» и ассоциируем его с правилом AuthorRule
        $updateOwnPost = $auth->createPermission(Permission::PERMISSION_UPDATE_OWN_POST);
        $updateOwnPost->description = Permission::PERMISSION_UPDATE_OWN_POST_DESCRIPTION;
        // Указываем правило AuthorRule для разрешения updateOwnPost.
        $updateOwnPost->ruleName = $authorRule->name;

        // Запишем эти разрешения в БД
        $auth->add($viewAdminPage);
        $auth->add($managerRbac);
        $auth->add($managerUsers);
        $auth->add($managerPosts);
        $auth->add($updateOwnPost);

        // Присваиваем разрешения редактору
        $auth->addChild($editor, $viewAdminPage);
        $auth->addChild($editor, $updateOwnPost);

        // Присваиваем разрешения менеджеру
        $auth->addChild($manager, $viewAdminPage);
        $auth->addChild($manager, $managerPosts);

        // Присваиваем разрешения админу
        $auth->addChild($admin, $viewAdminPage);
        $auth->addChild($admin, $managerPosts);
        $auth->addChild($admin, $managerUsers);

        // Присваиваем разрешения супер админу
        $auth->addChild($super_admin, $viewAdminPage);
        $auth->addChild($super_admin, $managerPosts);
        $auth->addChild($super_admin, $managerUsers);
        $auth->addChild($super_admin, $managerRbac);

        // Наследуем роли
        // редактор наследует роль пользователя default
        $auth->addChild($editor, $default);

        // менеджер наследует роль редактора
        $auth->addChild($manager, $editor);

        // админ наследует роль менеджера
        $auth->addChild($admin, $manager);

        // супер админ наследует роль админа
        $auth->addChild($super_admin, $admin);

        // Привязываем пользователей к ролям
        // Назначаем роль super_admin пользователю с ID 1
        $auth->assign($super_admin, 1); //Это супер админ

        // Назначаем роль manager пользователю с ID 2
        //$auth->assign($manager, 2);

        // Назначаем роль модератора пользователю с ID 3
        //$auth->assign($moderator, 3);

        // Назначаем роль editor пользователю с ID 4
        //$auth->assign($editor, 4);

        // Назначаем роль user пользователю с ID 5
        //$auth->assign($default, 5);

        return true;
    }
}