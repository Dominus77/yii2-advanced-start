<?php

namespace modules\users\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use modules\users\Module;

/**
 * Class BaseUser
 * @package modules\users\models
 *
 * @property int|string $id ID
 * @property string $auth_key Authorization Key
 * @property string $email_confirm_token Email Confirm Token
 * @property int|string $status
 * @property string $statusLabelName
 * @property string $statusName
 * @property array $statusesArray
 * @property-read string $authKey
 * @property array $labelsArray
 */
class BaseUser extends ActiveRecord implements IdentityInterface
{
    // Statuses
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
    const STATUS_DELETED = 3;

    private static $identity;
    private static $identityByAccessToken;

    /**
     * {@inheritdoc}
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @param int|string $id
     * @return $this|null
     */
    public static function findIdentity($id)
    {
        if (self::$identity === null) {
            self::$identity = static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }
        return self::$identity;
    }

    /**
     * @param mixed $token
     * @param mixed $type
     * @return $this|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (self::$identityByAccessToken === null) {
            self::$identityByAccessToken = static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
        }
        return self::$identityByAccessToken;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
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
        $this->auth_key = $this->generateUniqueRandomString('auth_key');
    }

    /**
     * Generates email confirmation token
     * @throws Exception
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = $this->generateUniqueRandomString('email_confirm_token');
    }

    /**
     * Generate Unique Random String
     * @param string $attribute
     * @param int $maxIteration
     * @return string
     * @throws Exception
     */
    public function generateUniqueRandomString($attribute, $maxIteration = 10)
    {
        $security = Yii::$app->security;
        if ($attribute && $maxIteration > 0) {
            $i = 0;
            while ($i <= $maxIteration) {
                $string = $security->generateRandomString();
                if ((static::findOne([$attribute => $string])) === null) {
                    return $string;
                }
                $i++;
            }
            throw new Exception('Failed to generate unique value, try increasing the number of iterations.');
        }
        return $security->generateRandomString();
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
            self::STATUS_BLOCKED => Module::translate('module', 'Blocked'),
            self::STATUS_ACTIVE => Module::translate('module', 'Active'),
            self::STATUS_WAIT => Module::translate('module', 'Wait'),
            self::STATUS_DELETED => Module::translate('module', 'Deleted')
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
     * @return mixed|null
     * @throws \Exception
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * Return <span class="label label-success">Active</span>
     *
     * @return string
     * @throws \Exception
     */
    public function getStatusLabelName()
    {
        $name = ArrayHelper::getValue(self::getLabelsArray(), $this->status);
        return Html::tag('span', $this->getStatusName(), ['class' => 'label label-' . $name]);
    }
}
