<?php

namespace modules\users\controllers\backend;

use Yii;
use yii\helpers\Url;
use modules\users\models\backend\User;
use modules\users\models\UploadForm;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use modules\users\Module;

/**
 * Class ProfileController
 * @package modules\users\controllers\backend
 */
class ProfileController extends Controller
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
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        if ($model = $this->findModel()) {
            $user_role = $model->getUserRoleValue();
            $model->role = $user_role ? $user_role : $model::RBAC_DEFAULT_ROLE;

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateProfile()
    {
        if ($model = $this->findModel()) {
            $model->scenario = $model::SCENARIO_ADMIN_UPDATE;

            $user_role = $model->getUserRoleValue();
            $model->role = $user_role ? $user_role : $model::RBAC_DEFAULT_ROLE;
            $_role = $model->role;

            if ($model->load(Yii::$app->request->post())) {
                // Если изменена роль
                if ($_role != $model->role) {
                    $authManager = Yii::$app->getAuthManager();
                    // Отвязываем старую роль если она существует
                    if ($role = $authManager->getRole($_role))
                        $authManager->revoke($role, $model->id);
                    // Привязываем новую
                    $role = $authManager->getRole($model->role);
                    $authManager->assign($role, $model->id);
                }
                if ($model->save())
                    Yii::$app->session->setFlash('success', Module::t('module', 'Profile successfully changed.'));
            }
        }
        return $this->redirect(['update', 'tab' => 'profile']);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdatePassword()
    {
        if ($model = $this->findModel()) {
            $model->scenario = $model::SCENARIO_PASSWORD_UPDATE;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', Module::t('module', 'Password changed successfully.'));
            }
        }
        return $this->redirect(['update', 'tab' => 'password']);
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateAvatar()
    {
        if ($model = $this->findModel()) {
            $model->scenario = $model::SCENARIO_AVATAR_UPDATE;
            $avatar = $model->avatar;
            if ($model->load(Yii::$app->request->post()) && ($model->scenario === $model::SCENARIO_AVATAR_UPDATE)) {
                if ($model->isDel) {
                    if ($avatar) {
                        $upload = Yii::$app->getModule('users')->uploads;
                        $path = str_replace('\\', '/', Url::to('@upload') . DIRECTORY_SEPARATOR . $upload . DIRECTORY_SEPARATOR . $model->id);
                        $avatar = $path . '/' . $avatar;
                        if (file_exists($avatar))
                            unlink($avatar);
                        $model->avatar = null;
                        $model->save();
                    }
                }
                $uploadModel = new UploadForm();
                if ($uploadModel->imageFile = UploadedFile::getInstance($model, 'imageFile'))
                    $uploadModel->upload($model->id);
            }
        }
        return $this->redirect(['update', 'tab' => 'avatar']);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        if (Yii::$app->request->post()) {
            $model = $this->findModel();
            $model->scenario = $model::SCENARIO_PROFILE_DELETE;

            $model->status = $model::STATUS_DELETED;
            if ($model->save()) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('success', Module::t('module', 'Profile successfully deleted.'));
                return $this->goHome();
            }
        }
        Yii::$app->session->setFlash('error', Module::t('module', 'Not the correct query format!'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = User::findOne(Yii::$app->user->identity->getId())) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
        }
    }
}
