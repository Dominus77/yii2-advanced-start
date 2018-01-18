<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class BackendController
 * @package app\controllers
 */
class BackendController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id == 'error')
            $this->layout = 'error.php';

        return parent::beforeAction($action);
    }
}
