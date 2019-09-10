<?php

namespace modules\rbac\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use modules\rbac\console\InitController;
use modules\rbac\Module;

/**
 * Class DefaultController
 * @package modules\rbac\controllers
 */
class DefaultController extends InitController
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['managerRbac']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'init' => YII_ENV_TEST ? ['GET'] : ['POST']
                ]
            ]
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

    /**
     * Переинициализация RBAC
     * с установкой настроек по умолчанию
     */
    public function actionInit()
    {
        if ($this->processInit()) {
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('success', Module::t('module', 'The operation was successful!'));
        }
        Yii::$app->getResponse()->redirect(Url::to(['index']));
    }
}
