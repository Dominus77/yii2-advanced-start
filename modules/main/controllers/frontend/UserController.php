<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 11.10.16
 * Time: 12:58
 */

namespace modules\main\controllers\frontend;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use modules\main\models\User;
use modules\main\models\frontend\UserUpdateForm;
use modules\main\models\frontend\PasswordChangeForm;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        $user = $this->findModel();
        $model = new UserUpdateForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionPasswordChange()
    {
        $user = $this->findModel();
        $model = new PasswordChangeForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'FLASH_PASSWORD_CHANGE_SUCCESS'));
            return $this->redirect(['index']);
        } else {
            return $this->render('passwordChange', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return User the loaded model
     */
    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }
}