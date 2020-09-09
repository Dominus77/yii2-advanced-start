<?php

namespace modules\users\models;

use yii\base\Exception;
use yii\base\Model;
use yii\base\InvalidArgumentException;
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
     * @var User
     */
    private $user;

    /**
     * Creates a form model given a token.
     *
     * @param mixed $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token = '', $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException(Module::translate('module', 'Password reset token cannot be blank.'));
        }
        $this->user = User::findByPasswordResetToken($token);
        if (!$this->user) {
            throw new InvalidArgumentException(Module::translate('module', 'Wrong password reset token.'));
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
            [
                'password',
                'string',
                'min' => User::LENGTH_STRING_PASSWORD_MIN,
                'max' => User::LENGTH_STRING_PASSWORD_MAX
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => Module::translate('module', 'New Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     * @throws Exception
     */
    public function resetPassword()
    {
        $user = $this->user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }
}
