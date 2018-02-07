<?php

namespace modules\rbac\console;

use Yii;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use yii\helpers\Console;
use modules\rbac\models\Role;
use modules\rbac\models\Permission;

/**
 * Class RbacController
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 *
 * @package console\controllers
 */
class InitController extends Controller
{
    const TYPE_ROLE = 'Roles';
    const TYPE_PERMISSION = 'Permissions';

    /**
     * Initialize RBAC
     */
    public function actionIndex()
    {
        /** @var yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;
        $this->processClear($auth);
        $roles = $this->processCreate($auth, $this->getRoles(), self::TYPE_ROLE);
        $permissions = $this->processCreate($auth, $this->getPermissions(), self::TYPE_PERMISSION);
        $this->processAddPermissionToRoles($auth, $roles, $permissions);
        $this->processAddChildRoles($auth, $roles);

        $role = ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN);
        if ($this->processAssignUserToRole($auth, $role, 1)) {
            $this->stdout('Done!', Console::FG_GREEN, Console::BOLD);
            $this->stdout(PHP_EOL);
        } else {
            $this->stderr('FAIL', Console::FG_RED, Console::BOLD);
        }
    }

    /**
     * Clear
     *
     * @param $auth yii\rbac\ManagerInterface
     * @return bool
     */
    protected function processClear($auth)
    {
        $auth->removeAll();
        return true;
    }

    /**
     * Create Roles and Permissions
     *
     * @param yii\rbac\DbManager $auth
     * @param array $array
     * @param string $type
     * @return array
     */
    protected function processCreate($auth, $array = [], $type = self::TYPE_ROLE)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[$key] = ($type === self::TYPE_ROLE) ? $auth->createRole($key) : $auth->createPermission($key);
            $result[$key]->description = $value;
            // Add rules
            if ($key == Permission::PERMISSION_UPDATE_OWN_POST) {
                $authorRule = new \modules\rbac\components\AuthorRule;
                $auth->add($authorRule);
                $result[$key]->ruleName = $authorRule->name;
            }
            $auth->add($result[$key]);
        }
        return $result;
    }

    /**
     * Add Permissions for Roles
     *
     * @param yii\rbac\DbManager $auth
     * @param array $roles
     * @param array $permissions
     */
    protected function processAddPermissionToRoles($auth, $roles = [], $permissions = [])
    {
        // ROLE_SUPER_ADMIN
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_POST));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_USERS));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_RBAC));
        // ROLE_ADMIN
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_POST));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_USERS));
        // ROLE_MANAGER
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_MANAGER),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_MANAGER),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_MANAGER_POST));
        // ROLE_EDITOR
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_EDITOR),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_VIEW_ADMIN_PAGE));
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_EDITOR),
            ArrayHelper::getValue($permissions, Permission::PERMISSION_UPDATE_OWN_POST));
    }

    /**
     * Add Child role for Roles
     *
     * @param yii\rbac\DbManager $auth
     * @param array $roles
     */
    protected function processAddChildRoles($auth, $roles = [])
    {
        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN),
            ArrayHelper::getValue($roles, Role::ROLE_ADMIN));

        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_ADMIN),
            ArrayHelper::getValue($roles, Role::ROLE_MANAGER));

        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_MANAGER),
            ArrayHelper::getValue($roles, Role::ROLE_EDITOR));

        $auth->addChild(ArrayHelper::getValue($roles, Role::ROLE_EDITOR),
            ArrayHelper::getValue($roles, Role::ROLE_DEFAULT));
    }

    /**
     * Assign Role to User
     *
     * @param yii\rbac\DbManager $auth
     * @param array $role
     * @param int $userId
     * @return bool
     */
    protected function processAssignUserToRole($auth, $role, $userId = 1)
    {
        $auth->assign($role, $userId);
        return true;
    }

    /**
     * Roles
     *
     * @return array
     */
    protected function getRoles()
    {
        $roles = [
            Role::ROLE_SUPER_ADMIN => Role::ROLE_SUPER_ADMIN_DESCRIPTION,
            Role::ROLE_ADMIN => Role::ROLE_ADMIN_DESCRIPTION,
            Role::ROLE_MANAGER => Role::ROLE_MANAGER_DESCRIPTION,
            Role::ROLE_EDITOR => Role::ROLE_EDITOR_DESCRIPTION,
            Role::ROLE_DEFAULT => Role::ROLE_DEFAULT_DESCRIPTION,
        ];
        return $roles;
    }

    /**
     * Permissions
     *
     * @return array
     */
    protected function getPermissions()
    {
        $permissions = [
            Permission::PERMISSION_VIEW_ADMIN_PAGE => Permission::PERMISSION_VIEW_ADMIN_PAGE_DESCRIPTION,
            Permission::PERMISSION_MANAGER_RBAC => Permission::PERMISSION_MANAGER_RBAC_DESCRIPTION,
            Permission::PERMISSION_MANAGER_USERS => Permission::PERMISSION_MANAGER_USERS_DESCRIPTION,
            Permission::PERMISSION_MANAGER_POST => Permission::PERMISSION_MANAGER_POST_DESCRIPTION,
            Permission::PERMISSION_UPDATE_OWN_POST => Permission::PERMISSION_UPDATE_OWN_POST_DESCRIPTION,
        ];
        return $permissions;
    }
}
