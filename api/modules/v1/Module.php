<?php

namespace api\modules\v1;

use Yii;
use yii\filters\RateLimiter;
use api\components\IpLimiter;

/**
 * Class Module
 * @package api\modules\v1
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => RateLimiter::className(),
                'user' => new IpLimiter(),
                'enableRateLimitHeaders' => true,
                'errorMessage' => Yii::t('app', 'Exceeded the limit of applications!'),
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
