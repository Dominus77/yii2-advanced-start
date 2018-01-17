<?php

namespace modules\users\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\users\Module;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property integer $last_visit
 * @property string $email_confirm_token
 * @property string $avatar
 * @property string $first_name
 * @property string $last_name
 * @property string $registration_type
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
    const STATUS_DELETED = 3;

    const LENGTH_STRING_PASSWORD_MIN = 6;
    const LENGTH_STRING_PASSWORD_MAX = 16;

    const RBAC_DEFAULT_ROLE = \modules\rbac\models\Role::ROLE_DEFAULT;

    public $role;
    public $imageFile;
    public $isDel;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::className(), 'message' => Module::t('module', 'This username is already taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => Module::t('module', 'This email is already taken.')],
            ['email', 'string', 'max' => 255],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            [['first_name', 'last_name'], 'string', 'max' => 45],

            [['role', 'registration_type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
            'last_visit' => Module::t('module', 'Last Visit'),
            'username' => Module::t('module', 'Username'),
            'email' => Module::t('module', 'Email'),
            'auth_key' => Module::t('module', 'Auth Key'),
            'status' => Module::t('module', 'Status'),
            'role' => Module::t('module', 'Role'),
            'userRoleName' => Module::t('module', 'Role'),
            'avatar' => Module::t('module', 'Avatar'),
            'first_name' => Module::t('module', 'First Name'),
            'last_name' => Module::t('module', 'Last Name'),
            'registration_type' => Module::t('module', 'Registration Type'),
            'imageFile' => Module::t('module', 'Avatar'),
            'isDel' => Module::t('module', 'Delete Avatar'),
        ];
    }

    /**
     * @return string
     */
    public function getAvatarPath()
    {
        if ($this->avatar != null) {
            $upload = Yii::$app->getModule('users')->uploads;
            $path = Yii::$app->params['domainFrontend'] . '/' . $upload . '/' . $this->id . '/' . $this->avatar;
            return $path;
        }
        return null;
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
     * @return string
     */
    public function getRegistrationType()
    {
        if ($this->registration_type > 0) {
            if (($model = User::findOne($this->registration_type)) !== null) {
                return $model->username;
            }
        }
        return Module::t('module', 'System');
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
        return Html::tag('span', self::getStatusName(), ['class' => 'label label-' . $name]);
    }

    /**
     * @return array
     */
    public function getRolesArray()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    /**
     * @return mixed|null
     */
    public function getUserRoleName()
    {
        if ($role = Yii::$app->authManager->getRolesByUser($this->id))
            return ArrayHelper::getValue($role, function ($role, $defaultValue) {
                foreach ($role as $key => $value) {
                    return $value->description;
                }
                return null;
            });
        return null;
    }

    /**
     * @return mixed
     */
    public function getRoleName()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($this->id);
        $role = '';
        foreach ($roles as $item) {
            $role .= $item->description ? $item->description . ', ' : $item->name . ', ';
        }
        return chop($role, ' ,');
    }

    /**
     * Получаем роль пользователя
     */
    public function getRoleUser()
    {
        if ($role = Yii::$app->authManager->getRolesByUser($this->id))
            return ArrayHelper::getValue($role, function ($role, $defaultValue) {
                foreach ($role as $key => $value) {
                    return $value->name;
                }
                return null;
            });
        return null;
    }

    /**
     * @param null $user_id
     * @return mixed|null
     */
    public function getUserRoleValue($user_id = null)
    {
        if ($user_id) {
            if ($role = Yii::$app->authManager->getRolesByUser($user_id))
                return ArrayHelper::getValue($role, function ($role) {
                    foreach ($role as $key => $value) {
                        return $value->name;
                    }
                    return null;
                });
        } else {
            if ($role = Yii::$app->authManager->getRolesByUser($this->id))
                return ArrayHelper::getValue($role, function ($role) {
                    foreach ($role as $key => $value) {
                        return $value->name;
                    }
                    return null;
                });
        }
        return null;
    }

    /**
     * @return string
     */
    public function getUserFullName()
    {
        if (Yii::$app->user) {
            if ($this->first_name && $this->last_name) {
                $fullName = $this->first_name . ' ' . $this->last_name;
            } else if ($this->first_name) {
                $fullName = $this->first_name;
            } else if ($this->last_name) {
                $fullName = $this->last_name;
            } else {
                $fullName = $this->username;
            }
            return Html::encode($fullName);
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByUsernameEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username or email
     *
     * @param string $string
     * @return static|null
     */
    public static function findByUsernameOrEmail($string)
    {
        return static::find()
            ->where(['or', ['username' => $string], ['email' => $string]])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param string $email_confirm_token
     * @return static|null
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne(['email_confirm_token' => $email_confirm_token, 'status' => self::STATUS_WAIT]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->status === self::STATUS_DELETED;
    }

    /**
     * Gravatar Service
     * @url https://www.gravatar.com
     *
     * @param $email
     * @param int $s
     * @param string $d
     * @param string $r
     * @param bool $img
     * @param array $attr
     * @return string
     */
    public function getGravatar($email = null, $s = 80, $d = 'mm', $r = 'g', $img = false, $attr = [])
    {
        $email = empty($email) ? $this->email : $email;

        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email))) . '?';
        $url .= http_build_query([
            's' => $s,
            'd' => $d,
            'r' => $r,
        ]);

        return $img ? Html::img($url, $attr) : $url;
    }

    /**
     * Действия перед сохранением
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    /**
     * Действия после сохранения
     * @param bool $insert
     * @param array $changedAttributes
     */
    /*public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {

        }
    }*/

    /**
     * Действия перед удалением
     * @return bool
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        $this->revokeRoles();
        $this->removeAvatar();
        return true;
    }

    /**
     * Отвязываем пользователя от всех ролей
     */
    public function revokeRoles()
    {
        $authManager = Yii::$app->getAuthManager();
        if ($authManager->getRolesByUser($this->id)) {
            $authManager->revokeAll($this->id);
        }
    }

    /**
     * Удаляем аватарку
     */
    public function removeAvatar()
    {
        if ($this->avatar) {
            $upload = Yii::$app->getModule('users')->uploads;
            $path = str_replace('\\', '/', Url::to('@upload') . DIRECTORY_SEPARATOR . $upload . DIRECTORY_SEPARATOR . $this->id);
            $file = $path . DIRECTORY_SEPARATOR . $this->avatar;
            if (file_exists($file)) {
                unlink($file);
            }
            // удаляем папку пользователя
            if (is_dir($path)) {
                @rmdir($path);
            }
        }
    }
}
