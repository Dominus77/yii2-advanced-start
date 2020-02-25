<?php

namespace backend\controllers;

use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Class BackendController
 * @package backend\controllers
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
                'class' => ErrorAction::class
            ]
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
            $this->layout = 'error.php';
        }
        return parent::beforeAction($action);
    }
}
