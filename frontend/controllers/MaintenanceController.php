<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use common\components\maintenance\actions\frontend\IndexAction;
use common\components\maintenance\actions\frontend\SubscribeAction;

/**
 * Class MaintenanceController
 * @package frontend\controllers
 */
class MaintenanceController extends Controller
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
                    'subscribe' => ['POST'],
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
            'index' => [
                'class' => IndexAction::class
            ],
            'subscribe' => [
                'class' => SubscribeAction::class
            ]
        ];
    }
}
