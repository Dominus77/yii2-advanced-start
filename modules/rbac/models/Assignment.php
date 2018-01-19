<?php

namespace modules\rbac\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use modules\rbac\Module;

/**
 * Class Assignment
 * @package modules\rbac\models
 */
class Assignment extends Model
{
    public $user;
    public $id;
    public $username;
    public $role;
    public $isNewRecord = false;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['role'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role' => Module::t('module', 'Role'),
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
     * @param $id
     * @return string
     */
    public function getRoleName($id = null)
    {
        $id = $id ? $id : $this->user->id;
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($id);
        $role = '';
        foreach ($roles as $item) {
            $role .= $item->description ? $item->description . ', ' : $item->name . ', ';
        }
        return chop($role, ' ,');
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function getUserRoleName($id = null)
    {
        $id = $id ? $id : $this->user->id;
        if ($role = Yii::$app->authManager->getRolesByUser($id))
            return ArrayHelper::getValue($role, function ($role) {
                foreach ($role as $key => $value) {
                    return $value->description;
                }
                return null;
            });
        return null;
    }

    /**
     * Получаем роль пользователя
     * @param null $id
     * @return mixed|null
     */
    public function getRoleUser($id = null)
    {
        $id = $id ? $id : $this->user->id;
        if ($role = Yii::$app->authManager->getRolesByUser($id))
            return ArrayHelper::getValue($role, function ($role) {
                foreach ($role as $key => $value) {
                    return $value->name;
                }
                return null;
            });
        return null;
    }
}
