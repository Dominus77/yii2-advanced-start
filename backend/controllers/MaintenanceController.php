<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use modules\rbac\models\Permission;
use common\components\maintenance\actions\backend\IndexAction;

/**
 * Class MaintenanceController
 * @package backend\controllers
 */
class MaintenanceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Permission::PERMISSION_MANAGER_MAINTENANCE]
                    ]
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
            ]
        ];
    }
}
