<?php

namespace modules\users\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use modules\users\Module;

/**
 * Class LoginForm
 * @package modules\users\models
 *
 * @property string $email Email
 * @property string $password Password
 * @property-read IdentityInterface|ActiveRecord|null|array|User $user
 * @property bool $rememberMe Remember Me
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = false;

    /** @var User */
    private $_user;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('module', 'Username'),
            'email' => Module::t('module', 'Email'),
            'password' => Module::t('module', 'Password'),
            'rememberMe' => Module::t('module', 'Remember Me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user === null || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Module::t('module', 'Invalid email or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $getUser = $this->getUser();
            if ($getUser instanceof IdentityInterface) {
                /** @var yii\web\User $user */
                $user = Yii::$app->user;
                return $user->login($getUser, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }
        return false;
    }

    /**
     * Logout user
     * @return bool
     */
    public function logout()
    {
        /** @var yii\web\User $user */
        $user = Yii::$app->user;
        return $user->logout();
    }

    /**
     * Finds user by [[username]]
     *
     * @return array|User|IdentityInterface|ActiveRecord|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsernameEmail($this->email);
        }
        return $this->_user;
    }
}
