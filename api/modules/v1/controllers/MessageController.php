<?php

namespace api\modules\v1\controllers;

use yii\rest\Controller;
use api\modules\v1\models\Message;

/**
 * Class MessageController
 * @package api\modules\v1\controllers
 */
class MessageController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new Message();
        return $model->message;
    }
}
