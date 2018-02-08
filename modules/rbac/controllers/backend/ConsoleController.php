<?php

namespace modules\rbac\controllers\backend;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use modules\rbac\Module;

/**
 * Class ConsoleController
 * @package modules\rbac\console
 */
class ConsoleController extends \modules\rbac\console\InitController
{
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'init' => YII_ENV_TEST ? ['GET'] : ['POST'],
                ],
            ],
        ];
    }

    /**
     * Переинициализация RBAC
     * с установкой настроек по умолчанию
     */
    public function actionInit()
    {
        if ($this->processInit()) {
            Yii::$app->session->setFlash('success', Module::t('module', 'The operation was successful!'));
        }
        Yii::$app->getResponse()->redirect(Url::to(['default/index']));
    }
}
