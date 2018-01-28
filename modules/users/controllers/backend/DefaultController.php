<?php

namespace modules\users\controllers\backend;

use Yii;
use modules\users\models\User;
use modules\users\models\search\UserSearch;
use yii\web\NotFoundHttpException;
use modules\rbac\models\Assignment;
use modules\users\Module;

/**
 * Class DefaultController
 * @package modules\users\controllers\backend
 */
class DefaultController extends BaseController
{
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
     * @param int|string $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
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
     * @param int|string $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
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
     * @param int|string $id
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
     * @param int|string $id
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
     * @param int|string $id
     * @return array|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStatus($id)
    {
        if ($model = $this->processChangeStatus($id)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'body' => $model->getStatusLabelName(),
                    'success' => true,
                ];
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * @param int|string $id
     * @return bool|User|null
     * @throws NotFoundHttpException
     */
    private function processChangeStatus($id)
    {
        $model = $this->findModel($id);
        /** @var object $identity */
        $identity = Yii::$app->user->identity;
        if ($model->id !== $identity->id && !$model->isSuperAdmin($model->id)) {
            $model->setStatus();
            $model->save(false);
            return $model;
        }
        return false;
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int|string $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->isSuperAdmin()) {
            if ($model->isDeleted()) {
                $model->delete();
                Yii::$app->session->setFlash('success', Module::t('module', 'The user "{:name}" have been successfully deleted.', [':name' => $model->username]));
            } else {
                /** @var $model \yii2tech\ar\softdelete\SoftDeleteBehavior */
                $model->softDelete();
                /** @var $model User */
                Yii::$app->session->setFlash('success', Module::t('module', 'The user "{:name}" are marked as deleted.', [':name' => $model->username]));
            }
        }
        return $this->redirect(['index']);
    }
}
