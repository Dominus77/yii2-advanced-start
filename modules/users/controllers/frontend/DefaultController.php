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
     * @inheritdoc
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
        $model = $this->findModel();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->processGoHome();
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
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->processGoHome();
    }

    /**
     * Signs user up.
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                return $this->processGoHome(Module::t('module', 'It remains to activate the account.'));
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @param mixed $token
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

        if ($model->confirmEmail()) {
            return $this->processGoHome(Module::t('module', 'Thank you for registering!'));
        }
        return $this->processGoHome(Module::t('module', 'Error sending message!'), 'error');
    }

    /**
     * Requests password reset.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                return $this->processGoHome(Module::t('module', 'Check your email for further instructions.'));
            } else {
                Yii::$app->session->setFlash('error', Module::t('module', 'Sorry, we are unable to reset password.'));
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param mixed $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $this->processResetPassword($model)) {
            return $this->processGoHome(Module::t('module', 'Password changed successfully.'));
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param ResetPasswordForm $model
     * @return bool|\yii\web\Response
     */
    protected function processResetPassword($model)
    {
        if ($model->validate() && $model->resetPassword()) {
            return true;
        }
        return false;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return null|User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (!Yii::$app->user->isGuest) {
            /** @var \modules\users\models\User $identity */
            $identity = Yii::$app->user->identity;
            if (($model = User::findOne($identity->id)) !== null) {
                return $model;
            }
        }
        throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
    }

    /**
     * @param string $message
     * @param string $type
     * @return \yii\web\Response
     */
    public function processGoHome($message = '', $type = 'success')
    {
        if (!empty($message)) {
            Yii::$app->session->setFlash($type, $message);
        }
        return $this->goHome();
    }
}
