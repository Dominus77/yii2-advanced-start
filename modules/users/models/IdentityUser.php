<?php

namespace modules\users\models;

use Yii;
use yii\helpers\Html;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use modules\users\traits\ModuleTrait;
use modules\users\Module;

/**
 * Class IdentityUser
 * @package modules\users\models
 *
 * This is the model class for table "{{%user}}".
 *
 * @property int $id ID
 * @property string $username Username
 * @property string $auth_key Authorization Key
 * @property string $password_hash Hash Password
 * @property string $password_reset_token Password Token
 * @property string $email_confirm_token Email Confirm Token
 * @property string $email Email
 * @property int|string $status Status
 * @property int $last_visit Last Visit
 * @property int $created_at Created
 * @property int $updated_at Updated
 * @property string $first_name First Name
 * @property string $last_name Last Name
 */
class IdentityUser extends ActiveRecord implements IdentityInterface
{
    use ModuleTrait;

    // Status
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
    const STATUS_DELETED = 3;

    const SCENARIO_ADMIN_CREATE = 'adminCreate';
    const SCENARIO_ADMIN_UPDATE = 'adminUpdate';
    const SCENARIO_ADMIN_PASSWORD_UPDATE = 'adminPasswordUpdate';
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    const SCENARIO_PASSWORD_UPDATE = 'passwordUpdate';
    const SCENARIO_PROFILE_DELETE = 'profileDelete';

    /**
     * @inheritdoc
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'status' => self::STATUS_DELETED,
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::class, 'message' => Module::t('module', 'This username is already taken.'), 'on' => [self::SCENARIO_ADMIN_CREATE]],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::class, 'message' => Module::t('module', 'This email is already taken.')],
            ['email', 'string', 'max' => 255],

            [['first_name', 'last_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     * @return array
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
     * @param int|string $id
     * @return IdentityInterface
     */
    public static function findIdentity($id)
    {
        /** @var IdentityInterface $result */
        $result = static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return $result;
    }

    /**
     * @inheritdoc
     * @param mixed $token
     * @param mixed $type
     * @return IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var IdentityInterface $result */
        $result = static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
        return $result;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string|mixed $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null|ActiveRecord
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return array|null|ActiveRecord
     */
    public static function findByUsernameEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username or email
     *
     * @param string $string
     * @return array|null|ActiveRecord
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
     * @param mixed $token password reset token
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
     * @param mixed $token password reset token
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
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
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
     * @param mixed $email_confirm_token
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
}
