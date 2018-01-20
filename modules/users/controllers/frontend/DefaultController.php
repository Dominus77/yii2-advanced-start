<?php
namespace modules\users\controllers\frontend;

use Yii;
use yii\web\Controller;
use modules\users\models\User;
use modules\users\models\SignupForm;
use modules\users\models\LoginForm;
use modules\users\models\EmailConfirmForm;
use modules\users\models\ResetPasswordForm;
use modules\users\models\PasswordResetRequestForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use modules\users\Module;

/**
 * Class DefaultController
 * @package modules\users\controllers\frontend
 */
class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post'],
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
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $session = Yii::$app->getSession();
                $session->setFlash('success', Module::t('module', 'It remains to activate the account.'));
                return $this->goHome();
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $session = Yii::$app->getSession();
        if ($model->confirmEmail()) {            
            $session->setFlash('success', Module::t('module', 'Thank you for registering!'));
        } else {
            $session->setFlash('error', Module::t('module', 'Error sending message!'));
        }

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $session = Yii::$app->getSession();
            if ($model->sendEmail()) {                
                $session->setFlash('success', Module::t('module', 'Check your email for further instructions.'));
                return $this->goHome();
            } else {
                $session->setFlash('error', Module::t('module', 'Sorry, we are unable to reset password.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $session = Yii::$app->getSession();
            $session->setFlash('success', Module::t('module', 'Password changed successfully.'));
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (!Yii::$app->user->isGuest) {
            $identity = Yii::$app->user->identity;        
            if (($model = User::findOne($identity->id)) !== null) {
                return $model;
            }
        }
        throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));        
    }
}
