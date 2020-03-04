<?php

namespace modules\rbac\controllers;

use Yii;
use modules\rbac\models\Assignment;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\Action;
use yii\web\Response;
use Exception;
use modules\rbac\Module;
use modules\users\models\User;

/**
 * Class AssignController
 * @package modules\rbac\controllers
 */
class AssignController extends Controller
{
    /** @var $user object */
    private $_user;

    /**
     * @param Action $action
     * @return bool
     * @throws InvalidConfigException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (empty(Yii::$app->controller->module->params['userClass'])) {
            throw new InvalidConfigException(Module::t('module', 'You must specify the User class in the module settings.'));
        }
        $this->_user = new Yii::$app->controller->module->params['userClass']();
        return parent::beforeAction($action);
    }

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
                    'revoke' => ['POST']
                ]
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $assignModel = new Assignment();
        $users = $this->_user->find()->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $users,
            'sort' => [
                'attributes' => ['username', 'role']
            ],
            'pagination' => [
                'defaultPageSize' => 25
            ]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'assignModel' => $assignModel
        ]);
    }

    /**
     * @param string|int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $assignModel = new Assignment();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'assignModel' => $assignModel
        ]);
    }

    /**
     * @param string|int $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = new Assignment([
            'user' => $this->findModel($id)
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->role);
            // отвязываем роли если есть
            if ($auth->getRolesByUser($model->user->id)) {
                $auth->revokeAll($model->user->id);
            }
            // Привязываем новую роль
            if ($auth->assign($role, $model->user->id)) {
                return $this->redirect(['view', 'id' => $model->user->id]);
            }
        }
        $model->role = $model->getRoleUser($id);
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param string|int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionRevoke($id)
    {
        /** @var User $model */
        $model = $this->findModel($id);
        $auth = Yii::$app->authManager;
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        if ($auth->getRolesByUser($model->id)) {
            if ($auth->revokeAll($model->id)) {
                $session->setFlash('success', Module::t('module', 'User "{:username}" successfully unassigned.', [':username' => $model->username]));
            } else {
                $session->setFlash('error', Module::t('module', 'Error!'));
            }
        } else {
            $session->setFlash('warning', Module::t('module', 'User "{:username}" is not attached to any role!', [':username' => $model->username]));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string|int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $userModel = $this->_user;
        if (($model = $userModel->findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
    }
}
