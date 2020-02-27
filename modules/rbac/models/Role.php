<?php

namespace modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\rbac\Item;
use modules\rbac\traits\ModuleTrait;
use modules\rbac\Module;

/**
 * Class Role
 * @package modules\rbac\models
 *
 * @property array $rolesArray
 */
class Role extends Model
{
    use ModuleTrait;

    // константы ролей
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_SUPER_ADMIN_DESCRIPTION = 'Super Administrator';

    const ROLE_ADMIN = 'admin';
    const ROLE_ADMIN_DESCRIPTION = 'Administrator';

    const ROLE_MANAGER = 'manager';
    const ROLE_MANAGER_DESCRIPTION = 'FileStateForm';

    const ROLE_EDITOR = 'editor';
    const ROLE_EDITOR_DESCRIPTION = 'Editor';

    const ROLE_DEFAULT = 'user';
    const ROLE_DEFAULT_DESCRIPTION = 'User';

    // сценарии
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $name;
    public $description;
    public $isNewRecord = false;

    /** @var  array $rolesByRole Наследуемые роли */
    public $rolesByRole;
    /** @var  array $itemsRoles Доступные роли */
    public $itemsRoles;

    /** @var  array $permissionsByRole Установленные разрешения для роли */
    public $permissionsByRole;
    /** @var array $itemsPermissions Разрешения */
    public $itemsPermissions;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required', 'on' => self::SCENARIO_CREATE],
            ['name', 'string', 'max' => 64, 'on' => self::SCENARIO_CREATE],
            ['name', 'match', 'pattern' => '#^[\w_-]+$#i', 'message' => Module::t('module', 'It is allowed to use the Latin alphabet, numbers, dashes and underscores.(A-z,0-1,-,_)'), 'on' => self::SCENARIO_CREATE],
            ['name', 'validateUniqueName', 'skipOnEmpty' => false, 'skipOnError' => false, 'on' => [self::SCENARIO_CREATE]],

            [['description'], 'string'],
            [['rolesByRole', 'itemsRoles', 'permissionsByRole', 'itemsPermissions'], 'required', 'message' => Module::t('module', 'You must select in the field «{attribute}».'), 'on' => self::SCENARIO_UPDATE]
        ];
    }

    /**
     * @param string $attribute
     */
    public function validateUniqueName($attribute)
    {
        if (!$attribute) {
            $this->addError($attribute, Module::t('module', 'Enter name role.'));
        }
        if (!$this->hasErrors()) {
            $this->processCheckRoleName($attribute);
        }
    }

    /**
     * Tree roles
     * @return array
     */
    public static function tree()
    {
        return [
            self::ROLE_SUPER_ADMIN => self::ROLE_ADMIN,
            self::ROLE_ADMIN => self::ROLE_MANAGER,
            self::ROLE_MANAGER => self::ROLE_EDITOR,
            self::ROLE_EDITOR => self::ROLE_DEFAULT
        ];
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function processCheckRoleName($attribute)
    {
        if (!empty($this->name)) {
            $auth = Yii::$app->authManager;
            if ($auth->getRole($this->name)) {
                $this->addError($attribute, Module::t('module', 'This name is already taken.'));
            }
        }
        return $attribute;
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'description'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'description', 'rolesByRole', 'itemsRoles', 'permissionsByRole', 'itemsPermissions'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'Name'),
            'description' => Module::t('module', 'Description'),
            'rolesByRole' => Module::t('module', 'Roles by role'),
            'itemsRoles' => Module::t('module', 'Items roles'),
            'permissionsByRole' => Module::t('module', 'Permissions by role'),
            'itemsPermissions' => Module::t('module', 'Items permissions')
        ];
    }

    /**
     * @return array
     */
    public function getRolesArray()
    {
        return [
            self::ROLE_SUPER_ADMIN => self::ROLE_SUPER_ADMIN_DESCRIPTION,
            self::ROLE_ADMIN => self::ROLE_ADMIN_DESCRIPTION,
            self::ROLE_MANAGER => self::ROLE_MANAGER_DESCRIPTION,
            self::ROLE_EDITOR => self::ROLE_EDITOR_DESCRIPTION,
            self::ROLE_DEFAULT => self::ROLE_DEFAULT_DESCRIPTION
        ];
    }

    /**
     * Возвращает установленные разрешения для роли
     * @return array
     */
    public function getPermissionsByRole()
    {
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermissionsByRole($this->name);
        $arr = [];
        foreach ($perm as $value) {
            if ($value->name !== $this->name) {
                $arr[$value->name] = $value->name . ' (' . $value->description . ')';
            }
        }
        return $arr;
    }

    /**
     * Возвращает все разрешения
     * @return array
     */
    public function getItemsPermissions()
    {
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermissions();
        $arr = [];
        foreach ($perm as $value) {
            if ($value->name !== $this->name) {
                $arr[$value->name] = $value->name . ' (' . $value->description . ')';
            }
        }
        $permByRole = $this->getPermissionsByRole();
        return array_diff($arr, $permByRole);
    }

    /**
     * Возвращает дочерние роли
     * @return array
     */
    public function getRolesByRole()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getChildRoles($this->name);
        $arr = [];
        foreach ($roles as $value) {
            if ($value->name !== $this->name) {
                $arr[$value->name] = $value->name . ' (' . $value->description . ')';
            }
        }
        return $arr;
    }

    /**
     * Возвращает все роли
     * @return array
     */
    public function getItemsRoles()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        $arr = [];
        foreach ($roles as $value) {
            if ($value->name !== $this->name) {
                $arr[$value->name] = $value->name . ' (' . $value->description . ')';
            }
        }
        $rolesByRole = $this->getRolesByRole();
        return array_diff($arr, $rolesByRole);
    }

    /**
     * @return \yii\rbac\Role[]
     */
    public function getRoleChild()
    {
        $auth = Yii::$app->authManager;
        return $auth->getChildRoles($this->name);
    }

    /**
     * Возвращает массив дочерних ролей
     * @return array
     */
    public function getRoleChildArray()
    {
        $roles = $this->getRoleChild();
        $arr = [];
        foreach ($roles as $value) {
            if ($value->name !== $this->name) {
                $arr[$value->name] = $value->description;
            }
        }
        return $arr;
    }

    /**
     * Получаем все роли
     * @return \yii\rbac\Role[]
     */
    public function getRoles()
    {
        $auth = Yii::$app->authManager;
        return $auth->getRoles();
    }

    /**
     * Возвращает массив ролей
     * @return array
     */
    public function getRoleItemsArray()
    {
        $roles = $this->getRoles();
        $arr = [];
        foreach ($roles as $value) {
            if ($value->name !== $this->name) {
                $arr[$value->name] = $value->description;
            }
        }
        return $arr;
    }

    /**
     *
     * @return array
     */
    public function getRolePermissions()
    {
        $auth = Yii::$app->authManager;
        $children = $auth->getChildren($this->name);
        $perm = [];
        foreach ($children as $key => $child) {
            if ($child->type === 2) {
                $perm[$key] = $child;
            }
        }
        return $perm;
    }

    /**
     * Все дети
     * @return Item[]
     */
    public function getChildren()
    {
        $auth = Yii::$app->authManager;
        return $auth->getChildren($this->name);
    }
}
