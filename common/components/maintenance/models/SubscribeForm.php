<?php

namespace common\components\maintenance\models;

use Yii;
use yii\base\Model;
use common\components\maintenance\StateInterface;
use common\components\maintenance\states\FileState;
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
 * @property string $format
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
        $this->state = new FileState();
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
     * Send all
     * @return int
     */
    public function sendAllNotify()
    {
        if ($this->emails) {
            $messages = [];
            $mailer = Yii::$app->mailer;
            foreach ($this->emails as $email) {
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
        return true;
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
    public function getFormat()
    {
        return $this->state->format;
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
     * @return string
     */
    public function getDatetime()
    {
        return $this->state->datetime();
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
