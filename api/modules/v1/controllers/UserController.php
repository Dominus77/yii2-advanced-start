<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
//use yii\filters\RateLimiter;
//use api\components\IpLimiter;

class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';

   /* public function behaviors()
    {
        $behaviors = parent::behaviors();
        //$behaviors['rateLimiter']['class'] = RateLimiter::className();
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;
        return $behaviors;
    }*/

    /*public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => RateLimiter::className(),
                'user' => new IpLimiter(),
                //'enableRateLimitHeaders' => true,
                //'errorMessage' => 'Превышен лимит обращений',
            ],
        ];
    }*/
}