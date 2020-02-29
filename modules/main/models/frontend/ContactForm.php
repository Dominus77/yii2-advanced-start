<?php

namespace modules\main\models\frontend;

use Yii;
use yii\helpers\Url;
use yii\base\Model;
use modules\main\Module;

/**
 * Class ContactForm
 * @package modules\main\models\frontend
 *
 * @property string $name Name
 * @property string $email Email
 * @property string $subject Subject
 * @property string $body Body
 * @property string $verifyCode Verify Code
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    const SCENARIO_GUEST = 'guest';

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            [['verifyCode'], 'required', 'on' => self::SCENARIO_GUEST],
            ['verifyCode', 'captcha', 'captchaAction' => Url::to('/main/default/captcha'), 'on' => self::SCENARIO_GUEST]
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_GUEST] = ['name', 'email', 'subject', 'body', 'verifyCode'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'Name'),
            'email' => Module::t('module', 'E-mail'),
            'subject' => Module::t('module', 'Subject'),
            'body' => Module::t('module', 'Body'),
            'verifyCode' => Module::t('module', 'Verification Code')
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
