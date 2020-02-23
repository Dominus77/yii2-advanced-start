<?php

namespace app\controllers;

use yii\base\Action;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;
use common\components\maintenance\actions\IndexAction;
use common\components\maintenance\actions\SubscribeAction;

/**
 * Class FrontendController
 * @package app\controllers
 */
class FrontendController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'maintenance-subscribe' => ['POST'],
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ],
            'maintenance' => [
                'class' => IndexAction::class
            ],
            'maintenance-subscribe' => [
                'class' => SubscribeAction::class
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
            $this->layout = 'main.php';
        }
        return parent::beforeAction($action);
    }
}
