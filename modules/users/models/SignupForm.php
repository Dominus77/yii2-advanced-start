<?php

namespace modules\users\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use modules\users\Module;

/**
 * Class SignupForm
 * @package modules\users\models
 *
 * @property string $username Username
 * @property string $email Email
 * @property string $password Password
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'message' => Module::translate('module', 'This username already exists.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'message' => Module::translate('module', 'This email already exists.')
            ],

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
            'username' => Module::translate('module', 'Username'),
            'email' => Module::translate('module', 'Email'),
            'password' => Module::translate('module', 'Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->status = User::STATUS_WAIT;
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();

            if ($user->save()) {
                Yii::$app->mailer->compose([
                    'html' => '@modules/users/mail/emailConfirm-html',
                    'text' => '@modules/users/mail/emailConfirm-text'
                ], ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject(
                        Module::translate(
                            'module',
                            'Account activation!'
                        ) . ' ' . Yii::$app->name
                    )->send();

                return $user;
            }
        }
        return null;
    }
}
