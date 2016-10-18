<?php
namespace modules\main\controllers\backend;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\components\rbac\Rbac as BackendRbac;

/**
 * Site controller
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [BackendRbac::PERMISSION_BACKEND],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can(BackendRbac::PERMISSION_BACKEND)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed.'));
            return $this->goHome();
        }
        return $this->render('index');
    }
}
