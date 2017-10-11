<?php
namespace modules\main\controllers\backend;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use modules\rbac\models\Permission;
use modules\main\Module;

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
                        'roles' => [Permission::PERMISSION_VIEW_ADMIN_PAGE],
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
        if (!Yii::$app->user->can(Permission::PERMISSION_VIEW_ADMIN_PAGE)) {
            Yii::$app->session->setFlash('error', Module::t('backend', 'MSG_YOU_NOT_ALLOWED'));
            return $this->goHome();
        }
        // Greeting in the admin panel, you can delete what would not be boring :)
        Yii::$app->session->setFlash('success', Module::t('backend', 'MSG_WELCOME'));

        return $this->render('index');
    }
}
