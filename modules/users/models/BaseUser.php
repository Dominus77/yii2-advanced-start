<?php
namespace modules\users\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\users\Module;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id ID
 * @property string $username Username
 * @property string $auth_key Authorization Key
 * @property string $password_hash Hash Password
 * @property string $password_reset_token Password Token
 * @property string $email_confirm_token Email Confirm Token
 * @property string $email Email
 * @property int $status Status
 * @property int $last_visit Last Visit
 * @property int $created_at Created
 * @property int $updated_at Updated
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property int $registration_type Type Registration
 */
class BaseUser extends ActiveRecord implements IdentityInterface
{
    // Status
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
    const STATUS_DELETED = 3;

    // Type of registration
    const TYPE_REGISTRATION_SYSTEM = 0;

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
            [['registration_type'], 'safe'],
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
            'first_name' => Module::t('module', 'First Name'),
            'last_name' => Module::t('module', 'Last Name'),
            'registration_type' => Module::t('module', 'Registration Type'),
        ];
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
    public static function isPasswordResetTokenValid($token = '')
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
     * @param $email_confirm_token
     * @return bool|null|static
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne([
            'email_confirm_token' => $email_confirm_token,
            'status' => self::STATUS_WAIT
        ]);
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
     * Actions before saving
     *
     * @param bool $insert
     * @return bool
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
}
