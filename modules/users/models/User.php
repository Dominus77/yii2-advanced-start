<?php

namespace modules\users\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\users\models\query\UserQuery;
use modules\users\Module;

/**
 * Class User
 * @package modules\users\models
 *
 * @property array statusesArray Array statuses
 * @property string userFullName Full user name
 * @property int|string registrationType Type registered
 * @property int $registration_type Type Registration
 * @property string statusLabelName Status name in label
 * @property string statusName Status name
 */
class User extends IdentityUser
{
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
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN_CREATE] = ['avatar', 'username', 'email', 'status', 'newPassword', 'newPasswordRepeat', 'registration_type', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_ADMIN_UPDATE] = ['username', 'email', 'status', 'first_name', 'last_name', 'newPassword', 'newPasswordRepeat'];
        $scenarios[self::SCENARIO_ADMIN_PASSWORD_UPDATE] = ['newPassword', 'newPasswordRepeat'];
        $scenarios[self::SCENARIO_PASSWORD_UPDATE] = ['currentPassword', 'newPassword', 'newPasswordRepeat'];
        $scenarios[self::SCENARIO_PROFILE_UPDATE] = ['username', 'email', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_PROFILE_DELETE] = ['status'];
        $scenarios['default'] = ['username', 'email', 'first_name', 'last_name', 'password_hash', 'status', 'auth_key', 'email_confirm_token'];
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
     * Type of registration
     * How the user is created
     * If the system registration type is registered by itself,
     * if it is created from the admin area,
     * then the login type that created the account
     *
     * @return mixed|string
     */
    public function getRegistrationType()
    {
        if ($this->registration_type > 0) {
            if (($model = User::findOne($this->registration_type)) !== null) {
                return $model->username;
            }
        }
        return $this->getRegistrationTypeName();
    }

    /**
     * Returns the registration type string
     * @return mixed
     */
    public function getRegistrationTypeName()
    {
        return ArrayHelper::getValue(self::getRegistrationTypesArray(), $this->registration_type);
    }

    /**
     * Returns an array of log types
     * @return array
     */
    public static function getRegistrationTypesArray()
    {
        return [
            self::TYPE_REGISTRATION_SYSTEM => Module::t('module', 'System'),
        ];
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

    /**
     * @return object|\yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(UserQuery::class, [get_called_class()]);
    }

    /**
     * Actions before saving
     *
     * @param bool $insert
     * @return bool
     */
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
            if ($insert) {
                $this->generateAuthKey();
            }
            if (!empty($this->newPassword)) {
                $this->setPassword($this->newPassword);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $authManager = Yii::$app->getAuthManager();
        if ($authManager->getRolesByUser($this->id)) {
            $authManager->revokeAll($this->id);
        }
        return true;
    }
}
