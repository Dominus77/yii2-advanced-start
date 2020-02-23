<?php

namespace common\components\maintenance\models;

use Generator;
use Yii;
use yii\base\Model;
use common\components\maintenance\states\FileState;

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
    public $email;

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
        return $this->save();
    }

    /**
     * Send Notify
     * @return bool
     */
    public function send()
    {
        return Yii::$app->mailer->compose([
            'html' => '@common/components/maintenance/mail/emailNotice-html',
            'text' => '@common/components/maintenance/mail/emailNotice-text'
        ], [])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject(Yii::t('app', 'Notification of completion of technical work'))
            ->send();
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
