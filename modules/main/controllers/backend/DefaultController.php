<?php

namespace modules\main\controllers\backend;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use modules\users\models\User;
use modules\rbac\models\Permission;
use modules\main\Module;

/**
 * Class DefaultController
 * @package modules\main\controllers\backend
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
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [Permission::PERMISSION_VIEW_ADMIN_PAGE]
                    ]
                ]
            ]
        ];
    }

    /**
     * Displays homepage.
     * @return mixed|Response
     */
    public function actionIndex()
    {
        /** @var yii\web\User $user */
        $user = Yii::$app->user;
        if (!$user->can(Permission::PERMISSION_VIEW_ADMIN_PAGE)) {
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('error', Module::t('module', 'You are not allowed access!'));
            return $this->goHome();
        }
        //Greeting in the admin panel :)
        /** @var User $identity */
        $identity = Yii::$app->user->identity;
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        $session->setFlash('info', Module::t('module', 'Welcome, {:username}!', [
            ':username' => $identity->username
        ]));
        return $this->render('index');
    }
}
