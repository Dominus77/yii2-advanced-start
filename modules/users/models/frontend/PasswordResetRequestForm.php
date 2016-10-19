<?php
namespace modules\users\models\frontend;

use Yii;
use yii\base\Model;
use modules\users\models\User;
use modules\users\Module;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\modules\users\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Module::t('frontend', 'MSG_NOT_USERS_FOR_EMAIL'),
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user \modules\users\models\User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => '@modules/users/mail/passwordResetToken-html', 'text' => '@modules/users/mail/passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject(Module::t('frontend', 'PASSWORD_RESET_FOR') . ' ' . Yii::$app->name)
            ->send();
    }
}
