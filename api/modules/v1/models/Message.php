<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;

/**
 * Class Message
 * @package api\modules\v1\models
 */
class Message extends Model
{
    public $message = 'This message api v1.';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message' => 'Message',
        ];
    }

    /**
     * /api/v1/message
     * @return array
     */
    public function fields()
    {
        return ['message'];
    }

    /**
     * /api/v1/message?expand=status
     * @return array
     */
    public function extraFields()
    {
        return [];
    }
}