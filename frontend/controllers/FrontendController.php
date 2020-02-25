<?php

namespace frontend\controllers;

use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Class FrontendController
 * @package frontend\controllers
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
                'class' => ErrorAction::class
            ],
        ];
    }

    /**
     * @param Action $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if ($action->id === 'error') {
            $this->layout = 'main.php';
        }
        return parent::beforeAction($action);
    }
}
