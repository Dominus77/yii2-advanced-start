<?php

namespace modules\users\controllers\backend;

use Yii;
use yii\helpers\Url;
use modules\users\models\LoginForm;
use modules\users\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use modules\rbac\models\Permission;
use yii\web\Response;
use modules\users\Module;

/**
 * Class BaseController
 * @package modules\users\controllers\backend
 */
class BaseController extends Controller
{
    /** @var  string|bool $jsFile */
    private $jsFile;

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => $this->getVerbs(),
            'access' => $this->getAccess()
        ];
    }

    /**
     * @return array
     */
    private function getVerbs()
    {
        return [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
                'logout' => ['POST'],
            ],
        ];
    }

    /**
     * @return array
     */
    private function getAccess()
    {
        return [
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
        $assetManager = Yii::$app->assetManager;
        $assetManager->publish($this->jsFile);
        $url = $assetManager->getPublishedUrl($this->jsFile);
        $this->view->registerJsFile($url,
            ['depends' => 'yii\web\JqueryAsset',] // depends
        );
    }

    /**
     * Action Generate new auth key
     * @param int|string $id
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionGenerateAuthKey($id)
    {
        $model = $this->processGenerateAuthKey($id);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'body' => $this->renderAjax('../../common/profile/col_auth_key', ['model' => $model, 'url' => Url::to(['generate-auth-key', 'id' => $model->id])]),
                'success' => true,
            ];
        }
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Generate new auth key
     * @param int|string $id
     * @return User|null
     * @throws NotFoundHttpException
     */
    public function processGenerateAuthKey($id)
    {
        $model = $this->findModel($id);
        $model->generateAuthKey();
        $model->save();
        return $model;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int|string $id
     * @return null|User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
    }

    /**
     * Login action.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = '//login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->processCheckPermissionLogin();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    protected function processCheckPermissionLogin()
    {
        // If access to Backend is denied, reset authorization, write a message to the session
        // and move it to the login page
        if (!Yii::$app->user->can(\modules\rbac\models\Permission::PERMISSION_VIEW_ADMIN_PAGE)) {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', Module::t('module', 'You do not have rights, access is denied.'));
            return $this->goHome();
        }
        return $this->goBack();
    }

    /**
     * Logout action.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        $model = new LoginForm();
        $model->logout();
        return $this->goHome();
    }
}
