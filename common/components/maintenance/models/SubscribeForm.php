<?php

namespace common\components\maintenance\models;

use Yii;
use yii\base\Model;
use common\components\maintenance\states\FileState;

/**
 * Class SubscribeForm
 * @package common\components\maintenance\models
 *
 * @property string $fileStatePath
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

    public function read()
    {
        $path = $this->getFileStatePath();
        return file_get_contents($path);
    }

    /**
     * @return string
     */
    protected function getFileStatePath()
    {
        return (new FileState())->path;
    }
}
