<?php

namespace modules\users\controllers\frontend;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\Controller;
use modules\users\models\SignupForm;
use modules\users\models\LoginForm;
use modules\users\models\EmailConfirmForm;
use modules\users\models\ResetPasswordForm;
use modules\users\models\PasswordResetRequestForm;
use yii\filters\AccessControl;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use modules\users\Module;
use yii\web\Response;

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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * Logs in a user.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->processGoHome();
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->processGoHome(Module::t('module', 'It remains to activate the account.'));
        }
        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * @param mixed $token
     * @return Response
     * @throws BadRequestHttpException
     * @throws \Exception
     */
    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidArgumentException $e) {
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
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                return $this->processGoHome(Module::t('module', 'Check your email for further instructions.'));
            }
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('error', Module::t('module', 'Sorry, we are unable to reset password.'));
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model
        ]);
    }

    /**
     * @param mixed $token
     * @return string|Response
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $this->processResetPassword($model)) {
            return $this->processGoHome(Module::t('module', 'Password changed successfully.'));
        }

        return $this->render('resetPassword', [
            'model' => $model
        ]);
    }

    /**
     * @param $model ResetPasswordForm|Model
     * @return bool
     * @throws Exception
     */
    protected function processResetPassword($model)
    {
        return $model->validate() && $model->resetPassword();
    }

    /**
     * @param string $message
     * @param string $type
     * @return Response
     */
    public function processGoHome($message = '', $type = 'success')
    {
        if (!empty($message)) {
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash($type, $message);
        }
        return $this->goHome();
    }
}
