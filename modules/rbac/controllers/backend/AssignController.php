<?php

namespace modules\rbac\controllers\backend;

use Yii;
use yii\helpers\Url;
use modules\rbac\models\Assignment;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use modules\rbac\Module;

/**
 * Class AssignController
 * @package modules\rbac\controllers\backend
 */
class AssignController extends Controller
{
    /** @var $user object */
    private $_user = null;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'revoke' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $users = $this->_user->find()->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $users,
            'sort' => [
                'attributes' => ['username', 'role'],
            ],
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
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
        $model->role = $model->getRoleUser();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRevoke($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $auth = Yii::$app->authManager;
            if ($auth->getRolesByUser($model->id)) {
                $auth->revokeAll($model->id);
                return [
                    'title' => Module::t('module', 'Done!'),
                    'text' => Module::t('module', 'User "{:username}" successfully unassigned.', [':username' => $model->username]),
                    'type' => 'success',
                ];
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $userModel = $this->_user;
        if (($model = $userModel->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
