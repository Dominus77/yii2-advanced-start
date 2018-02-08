<?php

namespace modules\rbac\controllers\backend;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use modules\rbac\Module;

/**
 * Class DefaultController
 * @package modules\rbac\controllers\backend
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['managerRbac'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
