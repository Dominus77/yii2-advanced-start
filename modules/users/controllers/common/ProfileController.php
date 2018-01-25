<?php

namespace modules\users\controllers\common;

use Yii;
use yii\web\Controller;
use modules\users\models\User;
use modules\rbac\models\Assignment;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
        $model = $this->findModel();

        $assignModel = new Assignment();
        $assignModel->user = $model;

        return $this->render('index', [
            'model' => $model,
            'assignModel' => $assignModel,
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        $model = $this->findModel();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateProfile()
    {
        $model = $this->findModel();
        $model->scenario = $model::SCENARIO_PROFILE_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Module::t('module', 'Profile successfully changed.'));
        } else {
            Yii::$app->session->setFlash('error', Module::t('module', 'Error! Profile not changed.'));
        }
        return $this->redirect(['update', 'tab' => 'profile']);
    }

    /**
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdatePassword()
    {
        $model = $this->findModel();
        $model->scenario = $model::SCENARIO_PASSWORD_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Module::t('module', 'Password changed successfully.'));
        } else {
            Yii::$app->session->setFlash('error', Module::t('module', 'Error! Password changed not successfully.'));
        }
        return $this->redirect(['update', 'tab' => 'password']);
    }

    /**
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionAjaxValidatePasswordForm()
    {
        $model = $this->findModel();
        $model->scenario = $model::SCENARIO_PASSWORD_UPDATE;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing User model.
     * This delete set status blocked, is successful, logout and the browser will be redirected to the 'home' page.
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete()
    {
        $model = $this->findModel();
        $model->scenario = $model::SCENARIO_PROFILE_DELETE;
        $model->status = $model::STATUS_DELETED;
        if ($model->save())
            Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Generate new auth key
     * @throws NotFoundHttpException
     */
    public function actionGenerateAuthKey()
    {
        $model = $this->findModel();
        $model->generateAuthKey();
        $model->save();
        $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return null|User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    private function findModel()
    {
        if (!Yii::$app->user->isGuest) {
            /** @var object $identity */
            $identity = Yii::$app->user->identity;
            if (($model = User::findOne($identity->id)) !== null) {
                return $model;
            }
        }
        throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
    }
}
