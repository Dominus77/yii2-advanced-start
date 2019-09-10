<?php


namespace modules\users\models;

use modules\users\Module;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\IdentityInterface;

/**
 * Class BaseUser
 * @package modules\users\models
 *
 * @property int $id ID
 * @property string $auth_key Authorization Key
 * @property string $email_confirm_token Email Confirm Token
 * @property int $status
 * @property string $statusLabelName
 * @property string $statusName
 * @property array $statusesArray
 * @property array $labelsArray
 */
class BaseUser extends ActiveRecord implements IdentityInterface
{
    // Statuses
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
    const STATUS_DELETED = 3;

    /**
     * {@inheritdoc}
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @param string|int $id
     * @return yii\db\ActiveRecord
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param mixed $token
     * @param mixed $type
     * @return yii\db\ActiveRecord
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        /** @var yii\base\Security $security */
        $security = Yii::$app->security;
        $this->auth_key = $security->generateRandomString();
    }

    /**
     * Generates email confirmation token
     * @throws Exception
     */
    public function generateEmailConfirmToken()
    {
        /** @var yii\base\Security $security */
        $security = Yii::$app->security;
        $this->email_confirm_token = $security->generateRandomString();
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
        $expire = Module::$passwordResetTokenExpire;
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
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
            'status' => self::STATUS_ACTIVE
        ]);
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
            self::STATUS_DELETED => Module::t('module', 'Deleted')
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
            self::STATUS_DELETED => 'danger'
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
        return Html::tag('span', $this->getStatusName(), ['class' => 'label label-' . $name]);
    }
}