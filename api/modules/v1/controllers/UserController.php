<?php

namespace api\modules\v1\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use api\modules\v1\models\User;

/**
 * Class UserController
 * @package api\modules\v1\controllers
 */
class UserController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = User::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'only' => ['update'],
            'authMethods' => [
                'bearerAuth' => [
                    'class' => HttpBearerAuth::class
                ],
                'paramAuth' => [
                    'class' => QueryParamAuth::class,
                    'tokenParam' => 'auth_key', // This value can be changed to its own, for example hash
                ],
                'basicAuth' => [
                    'class' => HttpBasicAuth::class,
                    'auth' => function ($username, $password) {
                        return $this->processBasicAuth($username, $password);
                    }
                ]
            ]
        ];
        return $behaviors;
    }

    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    protected function processBasicAuth($username, $password)
    {
        /** @var User $modelClass */
        $modelClass = $this->modelClass;
        /** @var User $user */
        if ($user = $modelClass::find()->where(['username' => $username])->one()) {
            return $user->validatePassword($password) ? $user : null;
        }
        return null;
    }
}
