<?php
namespace modules\users\models\frontend;

use Yii;
use yii\base\Model;
use modules\users\models\User;
use modules\users\Module;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    const LENGTH_STRING_PASSWORD_MIN = 6;
    const LENGTH_STRING_PASSWORD_MAX = 16;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'targetClass' => '\modules\users\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\modules\users\models\User', 'message' => Module::t('frontend', 'EMAIL_UNIQUE')],

            ['password', 'required'],
            ['password', 'string', 'min' => self::LENGTH_STRING_PASSWORD_MIN, 'max' => self::LENGTH_STRING_PASSWORD_MAX],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Module::t('frontend', 'USERNAME'),
            'email' => Module::t('frontend', 'EMAIL'),
            'password' => Module::t('frontend', 'PASSWORD'),
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
                    ->setSubject(Module::t('frontend', 'EMAIL_CONFIRMATION') . ' ' . Yii::$app->name)
                    ->send();
            }
            return $user;
        }
        return null;
    }
}
