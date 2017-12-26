<?php

namespace modules\users\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use api\components\IpLimiter;
//use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use modules\users\Module;

/**
 * Class DefaultController
 * @package modules\users\controllers\api
 */
class DefaultController extends ActiveController
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

        $behaviors['authenticator']['class'] = QueryParamAuth::className();
        $behaviors['authenticator']['only'] = ['update'];
        $behaviors['authenticator']['tokenParam'] = 'auth_key'; // This value can be changed to its own, for example hash

        return $behaviors;
    }
}