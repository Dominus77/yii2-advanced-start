<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;

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
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;

    const RBAC_DEFAULT_ROLE = 'user';

    public $role;

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
            ['username', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'ERROR_USERNAME_EXISTS')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'ERROR_EMAIL_EXISTS')],
            ['email', 'string', 'max' => 255],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            [['role'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Yii::t('app', 'CREATED'),
            'updated_at' => Yii::t('app', 'UPDATED'),
            'last_visit' => Yii::t('app', 'LAST_VISIT'),
            'username' => Yii::t('app', 'USERNAME'),
            'email' => Yii::t('app', 'EMAIL'),
            'status' => Yii::t('app', 'STATUS'),
            //'password' => Yii::t('app', 'PASSWORD'),
            'role' => Yii::t('app', 'ROLE'),
            'userRoleName' => Yii::t('app', 'ROLE'),
        ];
    }

    /**
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => Yii::t('app', 'STATUS_BLOCKED'),
            self::STATUS_ACTIVE => Yii::t('app', 'STATUS_ACTIVE'),
            self::STATUS_WAIT => Yii::t('app', 'STATUS_WAIT'),
        ];
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
     * @return mixed|null
     */
    public function getUserRoleValue()
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
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
     * Finds user by username or email
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsernameOrEmail($username)
    {
        return static::find()
            ->where(['or', ['username' => $username], ['email' => $username]])
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
     * Действия перед сохранением
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            } else {
                // Если изменена роль, выполняем требуемые действия
                // получаем текущую роль пользователя
                if($roleValue = self::getUserRoleValue()) {
                    // сравниваем с пришедшей в $this->role
                    if ($this->role && ($roleValue != $this->role)) {
                        // если отличаются, отвязываем текущую роль
                        $authManager = Yii::$app->getAuthManager();
                        $role = $authManager->getRole($roleValue);
                        $authManager->revoke($role, $this->id);
                        // привязываем из $this->role
                        $role = $authManager->getRole($this->role);
                        $authManager->assign($role, $this->id);
                    }
                } else {
                    $authManager = Yii::$app->getAuthManager();
                    $role = $this->role ? $authManager->getRole($this->role) : $authManager->getRole(self::RBAC_DEFAULT_ROLE);
                    $authManager->assign($role, $this->id);
                }
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
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            // Привязываем нового пользователя к роли
            $authManager = Yii::$app->getAuthManager();
            $role = $this->role ? $authManager->getRole($this->role) : $authManager->getRole(self::RBAC_DEFAULT_ROLE);
            $authManager->assign($role, $this->id);
        }
    }

    /**
     * Действия перед удалением
     * @return bool
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        // Отвязываем пользователя от всех ролей
        $authManager = Yii::$app->getAuthManager();
        if ($authManager->getRolesByUser($this->id)) {
            $authManager->revokeAll($this->id);
        }
        return true;
    }
}
