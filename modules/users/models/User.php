<?php

namespace modules\users\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\StaleObjectException;
use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use modules\rbac\models\Role;
use modules\users\models\query\UserQuery;
use modules\users\traits\ModuleTrait;
use modules\users\Module;
use Throwable;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int|string $id ID
 * @property string $username Username
 * @property string $email Email
 * @property string $auth_key Authorization Key
 * @property string $password_hash Hash Password
 * @property string $password_reset_token Password Token
 * @property string $email_confirm_token Email Confirm Token
 * @property int $created_at Created
 * @property int $updated_at Updated
 * @property int|string $status Status
 *
 * @property UserProfile $profile
 * @property string $statusLabelName
 * @property string $statusName
 * @property array $statusesArray
 * @property string $labelMailConfirm
 * @property-read string $userFullName
 * @property string $newPassword
 *
 * @method touch() TimestampBehavior
 */
class User extends BaseUser
{
    use ModuleTrait;

    // Length password
    const LENGTH_STRING_PASSWORD_MIN = 2;
    const LENGTH_STRING_PASSWORD_MAX = 32;

    const SCENARIO_ADMIN_CREATE = 'adminCreate';

    /**
     * @var string
     */
    public $password;

    /**
     * {@inheritdoc}
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'status' => self::STATUS_DELETED
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            [
                'username',
                'unique',
                'targetClass' => self::class,
                'message' => Module::translate('module', 'This username is already taken.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => self::class,
                'message' => Module::translate('module', 'This email is already taken.')
            ],
            ['email', 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email_confirm_token', 'password_reset_token', 'auth_key'], 'unique'],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            [['password'], 'required', 'on' => self::SCENARIO_ADMIN_CREATE],
            [
                'password',
                'string',
                'min' => self::LENGTH_STRING_PASSWORD_MIN,
                'max' => self::LENGTH_STRING_PASSWORD_MAX
            ]
        ];
    }

    /**
     * {@inheritdoc}
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::translate('module', 'ID'),
            'username' => Module::translate('module', 'Username'),
            'email' => Module::translate('module', 'Email'),
            'auth_key' => Module::translate('module', 'Auth Key'),
            'password_hash' => Module::translate('module', 'Hash Password'),
            'password_reset_token' => Module::translate('module', 'Password Token'),
            'email_confirm_token' => Module::translate('module', 'Email Confirm Token'),
            'created_at' => Module::translate('module', 'Created'),
            'updated_at' => Module::translate('module', 'Updated'),
            'status' => Module::translate('module', 'Status'),
            'userRoleName' => Module::translate('module', 'User Role Name'),
            'password' => Module::translate('module', 'Password')
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(static::class);
    }

    /**
     * @return ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
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
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getLabelMailConfirm($name = 'default')
    {
        if ($this->status === self::STATUS_WAIT) {
            return Html::tag('span', Html::tag('span', '', [
                'class' => 'glyphicon glyphicon-envelope'
            ]), ['class' => 'label label-' . $name]);
        }
        return '';
    }

    /**
     * @return bool
     */
    public function sendConfirmEmail()
    {
        return Yii::$app->mailer->compose([
            'html' => '@modules/users/mail/emailConfirm-html',
            'text' => '@modules/users/mail/emailConfirm-text'
        ], ['user' => $this])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject(Module::translate('module', 'Account activation!') . ' ' . Yii::$app->name)
            ->send();
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
        $fullName = Module::translate('module', 'Guest');
        if (!Yii::$app->user->isGuest) {
            $fullName = $this->profile->first_name . ' ' . $this->profile->last_name;
            $fullName = ($fullName !== ' ') ? $fullName : $this->username;
        }
        return Html::encode(trim($fullName));
    }

    /**
     * @param int|string $id
     * @return bool
     */
    public function isSuperAdmin($id = '')
    {
        $id = $id ?: $this->id;
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRolesByUser($id);
        foreach ($roles as $role) {
            if ($role->name === Role::ROLE_SUPER_ADMIN) {
                return true;
            }
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
     * @param bool $insert
     * @return bool
     * @throws Exception
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
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $profile = new UserProfile([
                'user_id' => $this->id,
                'email_gravatar' => $this->email
            ]);
            $profile->save();
        }
    }

    /**
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function beforeDelete()
    {
        if ($this->isDeleted()) {
            $this->profile->delete();
            // Отвязываем от ролей
            $authManager = Yii::$app->getAuthManager();
            if ($authManager->getRolesByUser($this->id)) {
                $authManager->revokeAll($this->id);
            }
        }
        return parent::beforeDelete();
    }
}
