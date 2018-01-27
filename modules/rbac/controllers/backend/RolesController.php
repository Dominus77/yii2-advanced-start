<?php

namespace modules\rbac\controllers\backend;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;
use modules\rbac\models\Role;
use modules\rbac\Module;

/**
 * Class RolesController
 * @package modules\rbac\controllers\backend
 */
class RolesController extends Controller
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['managerRbac'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST']
                ],
            ],
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
                'attributes' => ['name', 'description', 'ruleName'],
            ],
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
     * @return array|string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new Role(['scenario' => Role::SCENARIO_CREATE]);
        $model->isNewRecord = true;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $auth = Yii::$app->authManager;
                $role = $auth->createRole($model->name);
                $role->description = $model->description;
                if ($auth->add($role)) {
                    return $this->redirect(['view', 'id' => $model->name]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
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
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($id);

        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE,
            'name' => $role->name,
            'description' => $role->description,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $role->description = $model->description;
            if ($auth->update($id, $role)) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Привязываем роль
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws \Exception
     */
    public function actionAddRoles()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->name);
            foreach ($model->itemsRoles as $value) {
                $add = $auth->getRole($value);
                // Проверяем, не является добовляемая роль родителем?
                $result = $this->detectLoop($role, $add);
                if (!$result) {
                    $auth->addChild($role, $add);
                } else {
                    Yii::$app->session->setFlash('error', Module::t('module', 'The role of the "{:parent}" is the parent of the "{:role}"!', [':parent' => $add->name, ':role' => $role->name]));
                }
            }
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-roles']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Отзываем роль
     * @return array|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionRemoveRoles()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE,
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
     * @return array|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws \Exception
     */
    public function actionAddPermissions()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->name);
            foreach ($model->itemsPermissions as $value) {
                $add = $auth->getPermission($value);
                // Проверяем, не является добовляемое разрешение родителем?
                $result = $this->detectLoop($role, $add);
                if (!$result) {
                    $auth->addChild($role, $add);
                } else {
                    Yii::$app->session->setFlash('error', Module::t('module', 'The permission of the "{:parent}" is the parent of the "{:permission}"!', [':parent' => $add->name, ':permission' => $role->name]));
                }
            }
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-permissions']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Отзываем разрешение
     * @return array|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionRemovePermissions()
    {
        $model = new Role([
            'scenario' => Role::SCENARIO_UPDATE,
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
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($id);
        if ($auth->remove($role)) {
            Yii::$app->session->setFlash('success', Module::t('module', 'The role "{:name}" have been successfully deleted.', [':name' => $role->name]));
        } else {
            Yii::$app->session->setFlash('error', Module::t('module', 'Error!'));
        }
        return $this->redirect(['index']);
    }

    /**
     * @param object $parent
     * @param object $child
     * @return bool
     */
    protected function detectLoop($parent, $child)
    {
        $auth = Yii::$app->authManager;
        if ($child->name === $parent->name) {
            return true;
        }
        foreach ($auth->getChildren($child->name) as $grandchild) {
            if ($this->detectLoop($parent, $grandchild)) {
                return true;
            }
        }
        return false;
    }
}
