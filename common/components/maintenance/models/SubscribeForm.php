<?php

namespace common\components\maintenance\models;

use Yii;
use yii\base\Model;
use common\components\maintenance\StateInterface;
use yii\helpers\ArrayHelper;
use Exception;

/**
 * Class SubscribeForm
 * @package common\components\maintenance\models
 *
 * @property string $fileStatePath
 * @property array $emails
 * @property string $datetime
 * @property int $timestamp
 * @property string $dateFormat
 * @property string $email
 */
class SubscribeForm extends Model
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->state = Yii::$container->get(StateInterface::class);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Your email'),
        ];
    }

    /**
     * Sending notifications to followers
     *
     * @param array $emails
     * @return bool|int
     */
    public function send($emails = [])
    {
        $emails = $emails ?: $this->emails;
        $messages = [];
        $mailer = Yii::$app->mailer;
        foreach ($emails as $email) {
            $messages[] = $mailer->compose([
                'html' => '@common/components/maintenance/mail/emailNotice-html',
                'text' => '@common/components/maintenance/mail/emailNotice-text'
            ], [])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($email)
                ->setSubject(Yii::t('app', 'Notification of completion of technical work'));

        }
        return $mailer->sendMultiple($messages);
    }

    /**
     * @return bool
     */
    public function subscribe()
    {
        if ($this->isEmail()) {
            return false;
        }
        return $this->save();
    }

    /**
     * @return string
     */
    public function getDatetime()
    {
        return $this->state->datetime($this->timestamp, $this->dateFormat);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getTimestamp()
    {
        return $this->state->timestamp();
    }

    /**
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->state->dateFormat;
    }

    /**
     * Emails subscribe
     * @return array
     */
    public function getEmails()
    {
        return $this->state->emails();
    }

    /**
     * Check email is subscribe
     * @return bool
     */
    public function isEmail()
    {
        return ArrayHelper::isIn($this->email, $this->emails);
    }

    /**
     * Save email in file
     * @return bool
     */
    protected function save()
    {
        return $this->state->save($this->email);
    }

    /**
     * Maintenance file path
     * @return string
     */
    protected function getFileStatePath()
    {
        return $this->state->path;
    }
}
