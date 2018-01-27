<?php

namespace modules\rbac\controllers\backend;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;
use modules\rbac\models\Permission;
use modules\rbac\Module;

/**
 * Class PermissionsController
 * @package modules\rbac\controllers\backend
 */
class PermissionsController extends Controller
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
     * Lists all Permission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $dataProvider = new ArrayDataProvider([
            'allModels' => $auth->getPermissions(),
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
     * Displays a single Permission model.
     * @param string|int $id
     * @return mixed
     */
    public function actionView($id)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($id);

        $model = new Permission(['name' => $permission->name]);
        return $this->render('view', [
            'permission' => $permission,
            'model' => $model,
        ]);
    }

    /**
     * Creates Permission a new Permission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new Permission(['scenario' => Permission::SCENARIO_CREATE]);
        $model->isNewRecord = true;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $auth = Yii::$app->authManager;
                $perm = $auth->createPermission($model->name);
                $perm->description = $model->description;
                if ($auth->add($perm)) {
                    return $this->redirect(['view', 'id' => $model->name]);
                }
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
        $model = new Permission(['scenario' => Permission::SCENARIO_CREATE]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return false;
    }

    /**
     * Updates an existing Permission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string|int $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermission($id);

        $model = new Permission([
            'scenario' => Permission::SCENARIO_UPDATE,
            'name' => $perm->name,
            'description' => $perm->description,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $perm->description = $model->description;
            if ($auth->update($id, $perm)) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Привязываем разрешение
     * @return array|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws \Exception
     */
    public function actionAddPermissions()
    {
        $model = new Permission([
            'scenario' => Permission::SCENARIO_UPDATE,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $permission = $auth->getPermission($model->name);
            foreach ($model->permissionItems as $perm) {
                $add = $auth->getPermission($perm);
                // Проверяем, не является добовляемое разрешение родителем?
                $result = $this->detectLoop($permission, $add);
                if (!$result) {
                    $auth->addChild($permission, $add);
                } else {
                    Yii::$app->session->setFlash('error', Module::t('module', 'The permission of the "{:parent}" is the parent of the "{:permission}"!', [':parent' => $add->name, ':permission' => $permission->name]));
                }
            }
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-permissions']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Отвязываем разрешение
     * @return array|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionRemovePermissions()
    {
        $model = new Permission([
            'scenario' => Permission::SCENARIO_UPDATE,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $permission = $auth->getPermission($model->name);
            foreach ($model->permissions as $perm) {
                $remove = $auth->getPermission($perm);
                $auth->removeChild($permission, $remove);
            }
            return $this->redirect(['update', 'id' => $model->name, '#' => 'assign-container-permissions']);
        }
        throw new BadRequestHttpException(Module::t('module', 'Not a valid request to the method!'));
    }

    /**
     * Deletes an existing Permission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string|int $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermission($id);
        if ($auth->remove($perm)) {
            Yii::$app->session->setFlash('success', Module::t('module', 'The permission "{:name}" have been successfully deleted.', [':name' => $perm->name]));
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
