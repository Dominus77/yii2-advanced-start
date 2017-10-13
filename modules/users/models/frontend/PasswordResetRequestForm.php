<?php
namespace modules\users\models\frontend;

use Yii;
use yii\base\Model;
use modules\users\Module;

/**
 * Class PasswordResetRequestForm
 * @package modules\users\models\frontend
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
                'targetClass' => '\modules\users\models\frontend\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Module::t('module', 'There is no user with this e-mail.'),
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
            ->setSubject(Module::t('module', 'Password reset for') . ' ' . Yii::$app->name)
            ->send();
    }
}
