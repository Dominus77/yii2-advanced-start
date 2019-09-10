<?php

namespace modules\rbac\traits;

use Yii;
use modules\rbac\Module;
use yii\rbac\Permission;
use yii\rbac\Role;
use yii\base\Exception;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 * @package modules\rbac\traits
 */
trait ModuleTrait
{
    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('rbac');
    }

    /**
     * @param $permissions
     * @param $role
     * @throws Exception
     */
    public static function addChild($permissions, $role)
    {
        /** @var  $auth */
        $auth = Yii::$app->authManager;
        foreach ($permissions as $value) {
            /** @var Permission|Role $add */
            $add = $auth->getPermission($value);
            // Проверяем, не является добовляемое разрешение родителем?
            $result = self::detectLoop($role, $add);
            if (!$result) {
                $auth->addChild($role, $add);
            } else {
                /** @var yii\web\Session $session */
                $session = Yii::$app->session;
                $session->setFlash('error', Module::t('module', 'The permission of the "{:parent}" is the parent of the "{:permission}"!', [':parent' => $add->name, ':permission' => $role->name]));
            }
        }
    }

    /**
     * @param object $parent
     * @param object $child
     * @return bool
     */
    protected static function detectLoop($parent, $child)
    {
        $auth = Yii::$app->authManager;
        if ($child->name === $parent->name) {
            return true;
        }
        foreach ($auth->getChildren($child->name) as $grandchild) {
            if (self::detectLoop($parent, $grandchild)) {
                return true;
            }
        }
        return false;
    }
}
