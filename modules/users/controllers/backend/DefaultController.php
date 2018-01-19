<?php
namespace modules\users\controllers\backend;

use Yii;
use modules\users\models\LoginForm;
use modules\users\models\User;
use modules\users\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use modules\rbac\models\Permission;
use modules\rbac\models\Assignment;
use modules\users\Module;

/**
 * Class DefaultController
 * @package modules\users\controllers\backend
 */
class DefaultController extends Controller
{
    protected $jsFile;

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
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'roles' => [Permission::PERMISSION_MANAGER_USERS]
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->processRegisterJs();
    }

    /**
     * Publish and register the required JS file
     */
    protected function processRegisterJs()
    {
        $this->jsFile = '@modules/users/views/ajax/ajax.js';
        Yii::$app->assetManager->publish($this->jsFile);
        $this->getView()->registerJsFile(
            Yii::$app->assetManager->getPublishedUrl($this->jsFile),
            ['depends' => 'yii\web\JqueryAsset',] // depends
        );
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $assignModel = new Assignment();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'assignModel' => $assignModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($model = $this->findModel($id)) {
            $assignModel = new Assignment([
                'user' => $model
            ]);
            return $this->render('view', [
                'model' => $model,
                'assignModel' => $assignModel,
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Generate new auth key
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionGenerateAuthKey($id)
    {
        $model = $this->findModel($id);
        $model->generateAuthKey();
        $model->save();
        $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->status = $model::STATUS_WAIT;
        /** @var \modules\users\models\User $identity */
        $identity = Yii::$app->user->identity;
        $model->registration_type = $identity->id;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $model->scenario = $model::SCENARIO_ADMIN_CREATE;
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
        if ($model = $this->findModel($id)) {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateProfile($id)
    {
        if ($model = $this->findModel($id)) {
            $model->scenario = $model::SCENARIO_ADMIN_UPDATE;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', Module::t('module', 'Profile successfully changed.'));
            } else {
                Yii::$app->session->setFlash('error', Module::t('module', 'Error! Profile not changed.'));
            }
        }
        return $this->redirect(['update', 'id' => $model->id, 'tab' => 'profile']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdatePassword($id)
    {
        if ($model = $this->findModel($id)) {
            $model->scenario = $model::SCENARIO_ADMIN_PASSWORD_UPDATE;

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', Module::t('module', 'Password changed successfully.'));
            } else {
                Yii::$app->session->setFlash('error', Module::t('module', 'Error! Password changed not successfully.'));
            }
        }
        return $this->redirect(['update', 'id' => $model->id, 'tab' => 'password']);
    }

    /**
     * Change Status
     * @param $id
     * @return array|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            if ($model = $this->findModel($id)) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                /**
                 * Запрещаем менять статус у себя
                 * @var \modules\users\models\User $identity
                 */
                $identity = Yii::$app->user->identity;
                if ($model->id !== $identity->id) {
                    $model->setStatus();
                    if ($model->save()) {
                        return [
                            'body' => $model->getStatusLabelName(),
                            'success' => true,
                        ];
                    }
                }
            }
        }
        return $this->redirect(['index']);
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
        // Запрещаем удалять самого себя
        if ($model->id !== Yii::$app->user->identity->getId()) {
            if ($model->isDeleted()) {
                if ($model->delete()) {
                    Yii::$app->session->setFlash('success', Module::t('module', 'The user "{:name}" have been successfully deleted.', [':name' => $model->username]));
                }
            } else {
                $model->scenario = $model::SCENARIO_PROFILE_DELETE;
                $model->status = $model::STATUS_DELETED;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Module::t('module', 'The user "{:name}" are marked as deleted.', [':name' => $model->username]));
                }
            }
        } else {
            Yii::$app->session->setFlash('warning', Module::t('module', 'You can not remove yourself.'));
        }
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
            throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = '//login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Если запрещен доступ к Backend сбрасываем авторизацию записываем сообщение в сессию
            // и перебрасываем на страницу входа
            if (!Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_VIEW_ADMIN_PAGE)) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', Module::t('module', 'You do not have rights, access is denied.'));
                return $this->goHome();
            }
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
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
