<?php

namespace common\components\maintenance\models;

use Yii;
use yii\base\Model;

/**
 * Class SubscribeForm
 * @package common\components\maintenance\models
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
        $this->send();
        return true;
    }

    /**
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
}
