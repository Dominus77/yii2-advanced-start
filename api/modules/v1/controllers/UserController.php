<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Class UserController
 * @package api\modules\v1\controllers
 */
class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';
}