<?php

namespace modules\rbac\console;

use Yii;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use modules\rbac\components\AuthorRule;
use console\components\helpers\Console;
use modules\rbac\models\Role;
use modules\rbac\models\Permission;
use modules\rbac\Module;
use Exception;

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
     * Color
     * @var bool
     */
    public $color = true;

    /**
     * Initialize RBAC
     */
    public function actionIndex()
    {
        if ($this->processInit()) {
            $this->stdout(
                Console::convertEncoding(Module::translate('module', 'Success!')),
                Console::FG_GREEN,
                Console::BOLD
            );
            $this->stdout(PHP_EOL);
        } else {
            $this->stderr(
                Console::convertEncoding(Module::translate('module', 'Fail!')),
                Console::FG_RED,
                Console::BOLD
            );
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function processInit()
    {
        $auth = Yii::$app->authManager;
        $this->processClear($auth);
        $roles = $this->processCreate($auth, Role::rolesArray());
        $permissions = $this->processCreate($auth, Permission::permissionsArray(), self::TYPE_PERMISSION);
        $this->processAddPermissionToRoles($auth, $roles, $permissions);

        $this->processAddChildRoles($auth, $roles); //Inheritance of roles - If you uncomment, the roles are inherited

        // Assign a super administrator role to the user from id 1
        $role = ArrayHelper::getValue($roles, Role::ROLE_SUPER_ADMIN);
        return $this->processAssignUserToRole($auth, $role);
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
     * @param object $auth
     * @param array $array
     * @param string $type
     * @return array
     */
    protected function processCreate($auth, $array = [], $type = self::TYPE_ROLE)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[$key] = ($type === self::TYPE_ROLE) ? $auth->createRole($key) : $auth->createPermission($key);
            $result[$key]->description = Module::translate('module', $value);
            // Add rules
            if ($key === Permission::PERMISSION_UPDATE_OWN_POST) {
                $authorRule = new AuthorRule;
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
     * @param object $auth
     * @param array $roles
     * @param array $permissions
     * @throws Exception
     */
    protected function processAddPermissionToRoles($auth, $roles = [], $permissions = [])
    {
        foreach (Permission::getGroups() as $role => $group) {
            foreach ($group as $permission) {
                $auth->addChild(
                    ArrayHelper::getValue($roles, $role),
                    ArrayHelper::getValue($permissions, $permission)
                );
            }
        }
    }

    /**
     * Add Child role for Roles
     *
     * @param object $auth
     * @param array $roles
     * @throws Exception
     */
    protected function processAddChildRoles($auth, $roles = [])
    {
        $array = $this->prepareArrayTree(Role::tree());
        foreach ($array as $item) {
            foreach ($item as $role => $child) {
                $auth->addChild(
                    ArrayHelper::getValue($roles, $role),
                    ArrayHelper::getValue($roles, $child)
                );
            }
        }
    }

    /**
     * @param array $array
     * @return array
     */
    protected function prepareArrayTree($array)
    {
        $result = [];
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $k => $v) {
                    if (is_string($k)) {
                        $result[][$key] = $k;
                    } elseif (is_string($v)) {
                        $result[][$key] = $v;
                    }
                    if (is_array($v)) {
                        $child = $this->prepareArrayTree([$k => $item[$k]]);
                        $result = array_merge($result, $child);
                    }
                }
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * Assign Role to User
     * @param object $auth
     * @param $role
     * @param integer $userId
     * @return bool
     */
    protected function processAssignUserToRole($auth, $role, $userId = 1)
    {
        $auth->assign($role, $userId);
        return true;
    }
}
