<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Class FrontendController
 * @package app\controllers
 */
class FrontendController extends Controller
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
            $this->layout = 'main.php';

        return parent::beforeAction($action);
    }
}
