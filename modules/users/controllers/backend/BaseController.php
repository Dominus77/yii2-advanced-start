<?php

namespace modules\users\controllers\backend;

use Yii;
use modules\users\models\LoginForm;
use modules\users\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use modules\rbac\models\Permission;
use modules\users\Module;

/**
 * Class BaseController
 * @package modules\users\controllers\backend
 */
class BaseController extends Controller
{
    /** @var  string|bool $jsFile */
    protected $jsFile;

    /**
     * @inheritdoc
     * @return array
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
        $assetManager = Yii::$app->assetManager;
        $assetManager->publish($this->jsFile);
        $url = $assetManager->getPublishedUrl($this->jsFile);
        $this->view->registerJsFile($url,
            ['depends' => 'yii\web\JqueryAsset',] // depends
        );
    }

    /**
     * Generate new auth key
     * @param int|string $id
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int|string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /** @var \modules\users\models\User $model */
        $model = $this->findModel($id);
        // Запрещаем удалять самого себя
        /** @var object $identity */
        $identity = Yii::$app->user->identity;
        if ($model->id !== $identity->id) {
            if ($model->isDeleted()) {
                if ($model->delete() !== false) {
                    Yii::$app->session->setFlash('success', Module::t('module', 'The user "{:name}" have been successfully deleted.', [':name' => $model->username]));
                }
            } else {
                $model->scenario = User::SCENARIO_PROFILE_DELETE;
                $model->status = User::STATUS_DELETED;
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
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        $model = new LoginForm();
        $model->logout();
        return $this->goHome();
    }
}
