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
     */
    public function getRolesArray()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        $arr = [];
        foreach ($roles as $value) {
            $arr[$value->name] = $value->name . ' (' . $value->description . ')';
        }
        return $arr;
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($this->user->id);
        $role = '';
        foreach ($roles as $item) {
            $role .= $item->description ? $item->description. ', ' : $item->name . ', ';
        }
        return chop($role, ' ,');
    }

    /**
     * @return mixed|null
     */
    public function getRoleUser()
    {
        if ($role = Yii::$app->authManager->getRolesByUser($this->user->id))
            return ArrayHelper::getValue($role, function ($role, $defaultValue) {
                foreach ($role as $key => $value) {
                    return $value->name;
                }
                return null;
            });
        return null;
    }
}
