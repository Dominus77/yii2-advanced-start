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
 *
 * @property array statusesArray Array statuses
 * @property string userFullName Full user name
 * @property int|string registrationType Type registered
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
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

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
            $this->processValidatePassword($attribute);
        } else {
            $this->addError($attribute, Module::t('module', 'Not all fields are filled in correctly.'));
        }
    }

    /**
     * @param string $attribute
     */
    protected function processValidatePassword($attribute)
    {
        if ($attribute) {
            if (!$this->validatePassword($this->$attribute))
                $this->addError($attribute, Module::t('module', 'Incorrect current password.'));
        } else {
            $this->addError($attribute, Module::t('module', 'Enter your current password.'));
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
     * @throws \yii\base\Exception
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
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => Module::t('module', 'Blocked'),
            self::STATUS_ACTIVE => Module::t('module', 'Active'),
            self::STATUS_WAIT => Module::t('module', 'Wait'),
            self::STATUS_DELETED => Module::t('module', 'Deleted'),
        ];
    }

    /**
     * Set Status
     * @return int|string
     */
    public function setStatus()
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                $this->status = self::STATUS_BLOCKED;
                break;
            case self::STATUS_DELETED:
                $this->status = self::STATUS_WAIT;
                break;
            default:
                $this->status = self::STATUS_ACTIVE;
        }
        return $this->status;
    }

    /**
     * @return string
     */
    public function getUserFullName()
    {
        $fullName = Module::t('module', 'Guest');
        if (!Yii::$app->user->isGuest) {
            $fullName = $this->first_name . ' ' . $this->last_name;
            $fullName = ($fullName != ' ') ? $fullName : $this->username;
        }
        return Html::encode(trim($fullName));
    }

    /**
     * @param integer|string $id
     * @return bool
     */
    public function isSuperAdmin($id = '')
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

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->status === self::STATUS_DELETED;
    }

    /**
     * @return mixed
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * Return <span class="label label-success">Active</span>
     * @return string
     */
    public function getStatusLabelName()
    {
        $name = ArrayHelper::getValue(self::getLabelsArray(), $this->status);
        return Html::tag('span', $this->getStatusName(), ['class' => 'label label-' . $name]);
    }

    /**
     * @return array
     */
    public static function getLabelsArray()
    {
        return [
            self::STATUS_BLOCKED => 'default',
            self::STATUS_ACTIVE => 'success',
            self::STATUS_WAIT => 'warning',
            self::STATUS_DELETED => 'danger',
        ];
    }
}
