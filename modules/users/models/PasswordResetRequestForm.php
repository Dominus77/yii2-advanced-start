<?php

namespace modules\users\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use modules\users\Module;

/**
 * Class PasswordResetRequestForm
 * @package modules\users\models\frontend
 *
 * @property-read bool|User $user
 * @property string $email Email
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Module::translate('module', 'There is no user with this e-mail.'),
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool
     * @throws Exception
     */
    public function sendEmail()
    {

        if ($user = $this->getUser()) {
            return Yii::$app->mailer->compose([
                'html' => '@modules/users/mail/passwordResetToken-html',
                'text' => '@modules/users/mail/passwordResetToken-text'
            ], ['user' => $user])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject(Module::translate('module', 'Password reset for') . ' ' . Yii::$app->name)
                ->send();
        }
        return false;
    }

    /**
     * @return false|User
     * @throws Exception
     */
    private function getUser()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user === null) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        return $user;
    }
}
