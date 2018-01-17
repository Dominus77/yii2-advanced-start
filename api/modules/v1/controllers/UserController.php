<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Class UserController
 * @package api\modules\v1\controllers
 */
class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'only' => ['update'],
            'authMethods' => [
                'bearerAuth' => [
                    'class' => HttpBearerAuth::className(),
                ],
                'paramAuth' => [
                    'class' => QueryParamAuth::className(),
                    'tokenParam' => 'auth_key', // This value can be changed to its own, for example hash
                ],
                'basicAuth' => [
                    'class' => HttpBasicAuth::className(),
                    'auth' => function ($username, $password) {
                        $modelClass = $this->modelClass;
                        if ($user = $modelClass::find()->where(['username' => $username])->one()) {
                            return $user->validatePassword($password) ? $user : null;
                        }
                        return null;
                    }
                ],
            ]
        ];
        return $behaviors;
    }
}
