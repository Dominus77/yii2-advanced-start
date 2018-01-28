<?php

namespace modules\users\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use modules\users\Module;

/**
 * Class ResetPasswordForm
 * @package modules\users\models\frontend
 *
 * @property string $password Password
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \modules\users\models\BaseUser
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param mixed $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token = '', $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Module::t('module', 'Password reset token cannot be blank.'));
        }
        $this->_user = BaseUser::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Module::t('module', 'Wrong password reset token.'));
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => User::LENGTH_STRING_PASSWORD_MIN, 'max' => User::LENGTH_STRING_PASSWORD_MAX],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => Module::t('module', 'New Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     * @throws \yii\base\Exception
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }
}
