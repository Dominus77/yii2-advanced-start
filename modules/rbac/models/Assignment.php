<?php

namespace modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use modules\rbac\traits\ModuleTrait;
use modules\rbac\Module;

/**
 * Class Assignment
 * @package modules\rbac\models
 *
 * @property object $user User
 * @property string|int $id Id
 * @property string $username Username
 * @property mixed $role Role
 * @property bool $isNewRecord Is New Record
 */
class Assignment extends Model
{
    use ModuleTrait;

    public $user;
    public $id;
    public $username;
    public $role;
    public $isNewRecord = false;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['role'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'role' => Module::t('module', 'Role')
        ];
    }

    /**
     * Список всех ролей
     * @return array
     */
    public function getRolesArray()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    /**
     * @param string|int $id
     * @return string
     */
    public function getRoleName($id)
    {
        $id = $id ?: $this->user->id;
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($id);
        $role = '';
        foreach ($roles as $item) {
            $role .= $item->description ? $item->description . ', ' : $item->name . ', ';
        }
        return rtrim($role, ' ,');
    }

    /**
     * @param string|int $id
     * @return mixed|null
     * TODO: Refactoring
     */
    public function getUserRoleName($id)
    {
        $id = $id ?: $this->user->id;
        if ($role = Yii::$app->authManager->getRolesByUser($id)) {
            return ArrayHelper::getValue($role, static function ($role) {
                foreach ($role as $key => $value) {
                    return $value->description;
                }
                return null;
            });
        }
        return null;
    }

    /**
     * Получаем роль пользователя
     * @param string|int $id
     * @return mixed|null
     * TODO: Refactoring
     */
    public function getRoleUser($id)
    {
        $id = $id ?: $this->user->id;
        if ($role = Yii::$app->authManager->getRolesByUser($id)) {
            return ArrayHelper::getValue($role, static function ($role) {
                foreach ($role as $key => $value) {
                    return $value->name;
                }
                return null;
            });
        }
        return null;
    }
}
