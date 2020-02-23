<?php

namespace common\components\maintenance\models;

use Generator;
use Yii;
use yii\base\Model;
use common\components\maintenance\states\FileState;
use yii\helpers\ArrayHelper;

/**
 * Class SubscribeForm
 * @package common\components\maintenance\models
 *
 * @property string $fileStatePath
 * @property array $emails
 * @property string $email
 */
class SubscribeForm extends Model
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var array|null
     */
    private $_emails;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->_emails = $this->getEmails();
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
     * Send all
     * @return int
     */
    public function sendAllNotify()
    {
        if ($this->_emails) {
            $messages = [];
            $mailer = Yii::$app->mailer;
            foreach ($this->_emails as $email) {
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
     * Check email is subscribe
     * @return bool
     */
    public function isEmail()
    {
        return ArrayHelper::isIn($this->email, $this->_emails);
    }

    /**
     * Return emails to subscribe
     * @return array
     */
    public function getEmails()
    {
        $contents = $this->readTheFile();
        $items = [];
        foreach ($contents as $key => $item) {
            if ($key === 0) {
                continue;
            }
            $items[] = $item;
        }
        return array_filter($items);
    }

    /**
     * Save email in file
     * @return bool
     */
    protected function save()
    {
        $path = $this->getFileStatePath();
        $fp = fopen($path, 'ab');
        fwrite($fp, $this->email . PHP_EOL);
        fclose($fp);
        return true;
    }

    /**
     * Read file
     * @return Generator
     */
    protected function readTheFile()
    {
        $path = $this->getFileStatePath();
        $handle = fopen($path, 'rb');
        while (!feof($handle)) {
            yield trim(fgets($handle));
        }
        fclose($handle);
    }

    /**
     * @return string
     */
    protected function getFileStatePath()
    {
        return (new FileState())->path;
    }
}
