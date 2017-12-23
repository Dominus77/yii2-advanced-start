<?php

namespace modules\users\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use api\components\IpLimiter;
use modules\users\Module;

/**
 * Class UserController
 * @package modules\users\controllers\api
 */
class UserController extends ActiveController
{
    public $modelClass = 'modules\users\models\api\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'user' => new IpLimiter(),
            'enableRateLimitHeaders' => true,
            'errorMessage' => Module::t('module', 'Exceeded the limit of applications!'),
        ];
        return $behaviors;
    }
}