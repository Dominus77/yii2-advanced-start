<?php

namespace api\modules\v1;

use Yii;
use yii\filters\RateLimiter;
use api\components\IpLimiter;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => RateLimiter::className(),
                'user' => new IpLimiter(),
                'enableRateLimitHeaders' => true,
                'errorMessage' => Yii::t('app', 'MSG_LIMIT_EXCEEDED'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}
