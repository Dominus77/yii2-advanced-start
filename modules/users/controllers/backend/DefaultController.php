<?php

namespace modules\users\controllers\backend;

use Yii;
use modules\users\models\LoginForm;
use modules\users\models\backend\User;
use modules\users\models\backend\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\components\rbac\Rbac as BackendRbac;

/**
 * UserController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'logout' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => [BackendRbac::PERMISSION_BACKEND_USER_MANAGER],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->role = $model::RBAC_DEFAULT_ROLE;

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                $authManager = Yii::$app->getAuthManager();
                $role = $authManager->getRole($model->role);
                $authManager->assign($role, $model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->role = $model->getUserRoleValue();
        $_role = $model->role;

        if (!Yii::$app->user->can(BackendRbac::PERMISSION_BACKEND_USER_UPDATE)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to edit the profile.'));
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post())) {
            // Если изменена роль
            if($_role != $model->role) {
                // Отвязываем старую роль
                $authManager = Yii::$app->getAuthManager();
                $role = $authManager->getRole($_role);
                $authManager->revoke($role, $model->id);
                // Привязываем новую
                $role = $authManager->getRole($model->role);
                $authManager->assign($role, $model->id);
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // Нельзя удалить профиль администратора
        if (($model->getUserRoleValue($model->id) == BackendRbac::ROLE_ADMINISTRATOR)) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You can not remove the Administrator profile.'));
            return $this->redirect(['index']);
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = '//login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Если запрещен доступ к Backend сбрасываем авторизацию записываем сообщение в сессию
            // и перебрасываем на страницу входа
            if (!Yii::$app->user->can(BackendRbac::PERMISSION_BACKEND)) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', Yii::t('app', 'You are denied access!'));
                return $this->goHome();
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
