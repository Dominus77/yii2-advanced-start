<?php

namespace modules\users\controllers\common;

use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\web\Controller;
use modules\users\models\User;
use modules\users\models\UpdatePasswordForm;
use modules\users\models\UserDeleteForm;
use modules\rbac\models\Assignment;
use yii\web\NotFoundHttpException;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use modules\users\Module;

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
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $model = $this->findModel();
        if ($model->profile->load(Yii::$app->request->post()) && $model->profile->save()) {
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('success', Module::t('module', 'Profile successfully save.'));
            return $this->redirect(['update', 'tab' => 'profile']);
        }
        return $this->render('update', [
            'model' => $model,
            'passwordForm' => new UpdatePasswordForm($model)
        ]);
    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdateAvatar()
    {
        $model = $this->findModel();
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        if ($model->profile->load(Yii::$app->request->post()) && $model->profile->save()) {
            $session->setFlash('success', Module::t('module', 'Form successfully saved.'));
        } else {
            $session->setFlash('error', Module::t('module', 'Error! Failed to save the form.'));
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
     * @return Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdatePassword()
    {
        $model = new UpdatePasswordForm($this->findModel());
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            $session->setFlash('success', Module::t('module', 'Password changed successfully.'));
        } else {
            $session->setFlash('error', Module::t('module', 'Error! Password changed not successfully.'));
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
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete()
    {
        $model = new UserDeleteForm($this->findModel());
        if ($model->load(Yii::$app->request->post()) && $model->userDelete()) {
            /** @var \yii\web\User $user */
            $user = Yii::$app->user;
            $user->logout();
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('success', Module::t('module', 'Your profile has been successfully deleted!'));
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
        throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
    }
}
