<?php

namespace modules\rbac\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Exception;
use modules\rbac\models\Role;
use modules\rbac\Module;
use modules\rbac\traits\ModuleTrait;

/**
 * Class RolesController
 * @package modules\rbac\controllers
 */
class RolesController extends Controller
{
    use ModuleTrait;

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['managerRbac']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $dataProvider = new ArrayDataProvider([
            'allModels' => $auth->getRoles(),
            'sort' => [
                'attributes' => ['name', 'description', 'ruleName']
            ],
            'pagination' => [
                'defaultPageSize' => 25
            ]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string|int $id
     * @return mixed
     */
    public function actionView($id)
    {
        $auth = Yii::$app->authManager;
        /** @var  $role */
        $role = $auth->getRole($id);

        $model = new Role(['name' => $role->name]);
        return $this->render('view', [
            'role' => $role,
            'model' => $model
        ]);
    }

    /**
     * Creates Role a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array|string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Role(['scenario' => Role::SCENARIO_CREATE]);
        $model->isNewRecord = true;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $role = $auth->createRole($model->name);
            $role->description = $model->description;
            if ($auth->add($role)) {
                return $this->redirect(['view', 'id' => $model->name]);
            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * @return array|bool
     */
    public function actionAjaxValidateForm()
    {
        $model = new Role(['scenario' => Role::SCENARIO_CREATE]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return false;
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string|int $id
     * @return string|Response
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;
        /** @var  $role */
        $role = $auth->getRole($id);

        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE,
            'name' => $role->name,
            'description' => $role->description
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $role->description = $model->description;
            if ($auth->update($id, $role)) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Привязываем роль
     * @return Response
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionAddRoles()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            /** @var  $role */
            $role = $auth->getRole($model->name);
            foreach ($model->itemsRoles as $value) {
                /** @var  $add */
                $add = $auth->getRole($value);
                // Проверяем, не является добовляемая роль родителем?
                $result = self::detectLoop($role, $add);
                if (!$result) {
                    $auth->addChild($role, $add);
                } else {
                    /** @var yii\web\Session $session */
                    $session = Yii::$app->session;
                    $session->setFlash('error', Module::t('module', 'The role of the "{:parent}" is the parent of the "{:role}"!', [':parent' => $add->name, ':role' => $role->name]));
                }
            }
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-roles']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Отзываем роль
     * @return array|Response
     * @throws BadRequestHttpException
     */
    public function actionRemoveRoles()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->name);
            foreach ($model->rolesByRole as $value) {
                $remove = $auth->getRole($value);
                $auth->removeChild($role, $remove);
            }
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-roles']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Привязываем разрешение
     * @return array|Response
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionAddPermissions()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            /** @var  $role */
            $role = $auth->getRole($model->name);
            self::addChild($model->itemsPermissions, $role);
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-permissions']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Отзываем разрешение
     * @return array|Response
     * @throws BadRequestHttpException
     */
    public function actionRemovePermissions()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->name);
            foreach ($model->permissionsByRole as $value) {
                $remove = $auth->getPermission($value);
                $auth->removeChild($role, $remove);
            }
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-permissions']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string|int $id
     * @return Response
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        /** @var  $role */
        $role = $auth->getRole($id);
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        if ($auth->remove($role)) {
            $session->setFlash('success', Module::t('module', 'The role "{:name}" have been successfully deleted.', [':name' => $role->name]));
        } else {
            $session->setFlash('error', Module::t('module', 'Error!'));
        }
        return $this->redirect(['index']);
    }
}
