<?php

namespace modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use modules\rbac\Module;

/**
 * Class Assignment
 * @package modules\rbac\models
 *
 * @property object $user User
 * @property string|int $id Id
 * @property string $username Username
 * @property mixed $role Role
 * @property-read array $rolesArray
 * @property bool $isNewRecord Is New Record
 */
class Assignment extends Model
{
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
            'role' => Module::translate('module', 'Role')
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
     * Получаем описание ролей пользователя
     * @param string|int $id
     * @return string|null
     */
    public function getUserRoleName($id)
    {
        $id = $id ?: $this->user->id;
        $auth = Yii::$app->authManager;
        if ($roles = $auth->getRolesByUser($id)) {
            $description = [];
            foreach ($roles as $key => $value) {
                $description[] = $value->description;
            }
            return implode($description);
        }
        return null;
    }

    /**
     * Получаем названия ролей пользователя
     * @param string|int $id
     * @return string|null
     */
    public function getRoleUser($id)
    {
        $id = $id ?: $this->user->id;
        $auth = Yii::$app->authManager;
        if ($roles = $auth->getRolesByUser($id)) {
            $name = [];
            foreach ($roles as $key => $value) {
                $name[] = $value->name;
            }
            return implode($name);
        }
        return null;
    }
}
