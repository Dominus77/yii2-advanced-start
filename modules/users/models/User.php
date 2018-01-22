<?php

namespace modules\users\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\users\traits\ModuleTrait;
use modules\users\Module;

/**
 * Class User
 * @package modules\users\models
 */
class User extends BaseUser
{
    use ModuleTrait;

    const LENGTH_STRING_PASSWORD_MIN = 6;
    const LENGTH_STRING_PASSWORD_MAX = 16;

    const SCENARIO_ADMIN_CREATE = 'adminCreate';
    const SCENARIO_ADMIN_UPDATE = 'adminUpdate';
    const SCENARIO_ADMIN_PASSWORD_UPDATE = 'adminPasswordUpdate';
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    const SCENARIO_PASSWORD_UPDATE = 'passwordUpdate';
    const SCENARIO_PROFILE_DELETE = 'profileDelete';

    /**
     * @var string
     */
    public $currentPassword;

    /**
     * @var string
     */
    public $newPassword;

    /**
     * @var string
     */
    public $newPasswordRepeat;

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['newPassword', 'newPasswordRepeat'], 'required', 'on' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_PASSWORD_UPDATE, self::SCENARIO_ADMIN_PASSWORD_UPDATE]],
            ['newPassword', 'string', 'min' => self::LENGTH_STRING_PASSWORD_MIN],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
            ['currentPassword', 'validateCurrentPassword', 'skipOnEmpty' => false, 'skipOnError' => false],
        ]);
    }

    /**
     * @param string $attribute
     */
    public function validateCurrentPassword($attribute)
    {
        if (!empty($this->newPassword) && !empty($this->newPasswordRepeat) && !$this->hasErrors()) {
            if ($this->$attribute) {
                if (!$this->validatePassword($this->$attribute))
                    $this->addError($attribute, Module::t('module', 'Incorrect current password.'));
            } else {
                $this->addError($attribute, Module::t('module', 'Enter your current password.'));
            }
        } else {
            $this->addError($attribute, Module::t('module', 'Not all fields are filled in correctly.'));
        }
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN_CREATE] = ['avatar', 'username', 'email', 'status', 'newPassword', 'newPasswordRepeat', 'registration_type', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_ADMIN_UPDATE] = ['username', 'email', 'status', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_ADMIN_PASSWORD_UPDATE] = ['newPassword', 'newPasswordRepeat'];
        $scenarios[self::SCENARIO_PASSWORD_UPDATE] = ['currentPassword', 'newPassword', 'newPasswordRepeat'];
        $scenarios[self::SCENARIO_PROFILE_UPDATE] = ['email', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_PROFILE_DELETE] = ['status'];
        $scenarios['default'] = ['username', 'email', 'password_hash', 'status', 'auth_key', 'email_confirm_token'];
        return $scenarios;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'userRoleName' => Module::t('module', 'Role'),
            'currentPassword' => Module::t('module', 'Current Password'),
            'newPassword' => Module::t('module', 'New Password'),
            'newPasswordRepeat' => Module::t('module', 'Repeat Password'),
        ]);
    }

    /**
     * Actions before saving
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->newPassword)) {
                $this->setPassword($this->newPassword);
                Yii::$app->session->setFlash('success', Module::t('module', 'Password changed successfully.'));
            }
            return true;
        }
        return false;
    }

    /**
     * Set Status
     */
    public function setStatus()
    {
        if ($this->status == self::STATUS_ACTIVE) {
            $this->status = self::STATUS_BLOCKED;
        } else if ($this->status == self::STATUS_BLOCKED) {
            $this->status = self::STATUS_ACTIVE;
        } else if ($this->status == self::STATUS_WAIT) {
            $this->status = self::STATUS_ACTIVE;
        } else if ($this->status == self::STATUS_DELETED) {
            $this->status = self::STATUS_WAIT;
        }
    }

    /**
     * @return string
     */
    public function getUserFullName()
    {
        $fullName = '';
        if (Yii::$app->user->identity) {
            if ($this->first_name && $this->last_name) {
                $fullName = $this->first_name . ' ' . $this->last_name;
            } else if ($this->first_name) {
                $fullName = $this->first_name;
            } else if ($this->last_name) {
                $fullName = $this->last_name;
            } else {
                $fullName = $this->username;
            }
        }
        return Html::encode($fullName);
    }

    /**
     * @param integer|string $id
     * @return bool
     */
    public function isSuperAdmin($id)
    {
        $id = $id ? $id : $this->id;
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRolesByUser($id);
        foreach ($roles as $role) {
            if ($role->name == \modules\rbac\models\Role::ROLE_SUPER_ADMIN)
                return true;
        }
        return false;
    }
}
