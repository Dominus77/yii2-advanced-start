<?php

namespace modules\users\controllers\common;

use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\web\UploadedFile;
use modules\users\models\UploadForm;
use modules\users\models\User;
use modules\users\models\UpdatePasswordForm;
use modules\users\models\UserDeleteForm;
use modules\rbac\models\Assignment;
use modules\users\Module;
use Throwable;

/**
 * Class ProfileController
 * @package modules\users\controllers\common
 */
class ProfileController extends Controller
{
    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $model = $this->findModel();

        $assignModel = new Assignment();
        $assignModel->user = $model;

        return $this->render('index', [
            'model' => $model,
            'assignModel' => $assignModel
        ]);
    }

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $model = $this->findModel();
        $uploadFormModel = new UploadForm();
        $load = $model->profile->load(Yii::$app->request->post());
        if ($load && $model->profile->save()) {
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('success', Module::translate('module', 'Profile successfully save.'));
            return $this->redirect(['update', 'tab' => 'profile']);
        }
        return $this->render('update', [
            'model' => $model,
            'uploadFormModel' => $uploadFormModel,
            'passwordForm' => new UpdatePasswordForm($model)
        ]);
    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateAvatar()
    {
        $model = $this->findModel();
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        $load = $model->profile->load(Yii::$app->request->post());
        if ($load && $model->profile->save()) {
            $session->setFlash('success', Module::translate('module', 'Form successfully saved.'));
        } else {
            $session->setFlash('error', Module::translate('module', 'Error! Failed to save the form.'));
        }
        return $this->redirect(['update', 'tab' => 'avatar']);
    }

    /**
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionAjaxValidateAvatarForm()
    {
        $model = $this->findModel();
        if (Yii::$app->request->isAjax && $model->profile->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model->profile);
        }
        return $this->redirect(['index']);
    }

    /**
     * Upload file
     * @return Response
     * @throws Exception
     */
    public function actionUploadImage()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (($result = $model->upload()) && !is_string($result)) {
                if (isset($result['imageFile'][0])) {
                    $session->setFlash('error', $result['imageFile'][0]);
                } else {
                    $session->setFlash('error', Module::translate('module', 'Failed to upload file.'));
                }
                return $this->redirect(['update', 'tab' => 'avatar']);
            }
        }
        return $this->redirect(['update', 'tab' => 'avatar', 'modal' => 'show']);
    }

    /**
     * Crop image
     * @return Response
     */
    public function actionCropAvatar()
    {
        $model = new UploadForm();
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        if (($post = Yii::$app->request->post()) && $model->load($post) && $model->crop()) {
            $session->setFlash('success', Module::translate('module', 'User avatar successfully save.'));
        }
        return $this->redirect(['update', 'tab' => 'avatar']);
    }

    /**
     * Get Avatar
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionAvatar()
    {
        if ($file = Yii::$app->request->get('filename')) {
            /** @var int|string $id */
            $id = Yii::$app->request->get('id') ?: Yii::$app->user->id;
            $model = new UploadForm();
            $storagePath = $model->getPath($id);
            $response = Yii::$app->getResponse();
            if (($steam = fopen("$storagePath/$file", 'rb')) !== false) {
                $response->headers->set('Content-Type', 'image/jpg');
                $response->format = Response::FORMAT_RAW;
                $response->stream = $steam;
                $response->send();
                return true;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Delete Avatar files
     * @param int|string $id
     * @return Response
     */
    public function actionDeleteAvatar($id)
    {
        $model = new UploadForm();
        $fileName = $model->getFileName();
        $avatar = $model->getPath($id) . DIRECTORY_SEPARATOR . $fileName;
        $thumb = $model->getPath($id) . DIRECTORY_SEPARATOR . UploadForm::PREFIX_THUMBNAIL . $fileName;
        $original = $model->getPath($id) . DIRECTORY_SEPARATOR . UploadForm::PREFIX_ORIGINAL . $fileName;
        $model->delete([$avatar, $thumb, $original]);
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        $session->setFlash('success', Module::translate('module', 'Successfully deleted.'));
        return $this->redirect(['update', 'tab' => 'avatar']);
    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdatePassword()
    {
        $model = new UpdatePasswordForm($this->findModel());
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        $load = $model->load(Yii::$app->request->post());
        if ($load && $model->resetPassword()) {
            $session->setFlash('success', Module::translate('module', 'Password changed successfully.'));
        } else {
            $session->setFlash('error', Module::translate('module', 'Error! Password changed not successfully.'));
        }
        return $this->redirect(['update', 'tab' => 'password']);
    }

    /**
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionAjaxValidatePasswordForm()
    {
        $model = new UpdatePasswordForm($this->findModel());
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return $this->redirect(['index']);
    }

    /**
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionAjaxValidatePasswordDeleteForm()
    {
        $model = new UserDeleteForm($this->findModel());
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return $this->redirect(['delete']);
    }

    /**
     * @return array|Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionGenerateAuthKey()
    {
        $model = $this->processGenerateAuthKey();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => $model->auth_key
            ];
        }
        return $this->redirect(['index']);
    }

    /**
     * @return User
     * @throws Exception
     * @throws NotFoundHttpException
     */
    private function processGenerateAuthKey()
    {
        $model = $this->findModel();
        $model->generateAuthKey();
        $model->save();
        return $model;
    }

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete()
    {
        $model = new UserDeleteForm($this->findModel());
        $load = $model->load(Yii::$app->request->post());
        if ($load && $model->userDelete() !== false) {
            /** @var \yii\web\User $user */
            $user = Yii::$app->user;
            $user->logout();
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('success', Module::translate('module', 'Your profile has been successfully deleted!'));
            return $this->goHome();
        }
        return $this->render('delete', [
            'model' => $model
        ]);
    }

    /**
     * @return User
     * @throws NotFoundHttpException
     */
    private function findModel()
    {
        /** @var \yii\web\User $user */
        $user = Yii::$app->user;
        if (!$user->isGuest) {
            /** @var User $identity */
            $identity = Yii::$app->user->identity;
            if (($model = User::findOne($identity->id)) !== null) {
                return $model;
            }
        }
        throw new NotFoundHttpException(Module::translate('module', 'The requested page does not exist.'));
    }
}
