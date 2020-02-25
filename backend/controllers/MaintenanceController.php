<?php

namespace backend\controllers;

use yii\web\Controller;
use common\components\maintenance\actions\backend\IndexAction;

/**
 * Class MaintenanceController
 * @package backend\controllers
 */
class MaintenanceController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class
            ]
        ];
    }
}
