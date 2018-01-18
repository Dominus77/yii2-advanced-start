<?php

namespace modules\users\models\frontend;

use Yii;
use yii\base\Model;
use modules\users\Module;

/**
 * Class SignupForm
 * @package modules\users\models\frontend
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => '\modules\users\models\frontend\User', 'message' => Module::t('module', 'This username already exists.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\modules\users\models\frontend\User', 'message' => Module::t('module', 'This email already exists.')],

            ['password', 'required'],
            ['password', 'string', 'min' => User::LENGTH_STRING_PASSWORD_MIN, 'max' => User::LENGTH_STRING_PASSWORD_MAX],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('module', 'Username'),
            'email' => Module::t('module', 'Email'),
            'password' => Module::t('module', 'Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return \modules\users\models\User|null the saved model or null if saving fails
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
                Yii::$app->mailer->compose(['text' => '@modules/users/mail/emailConfirm'], ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject(Module::t('module', 'The message was successfully sent!') . ' ' . Yii::$app->name)
                    ->send();

                return $user;
            }
        }
        return null;
    }
}
