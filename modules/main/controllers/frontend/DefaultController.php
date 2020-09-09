<?php

namespace modules\main\controllers\frontend;

use Yii;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\captcha\CaptchaAction;
use yii\web\Response;
use modules\main\models\frontend\ContactForm;
use modules\users\models\User;
use modules\main\Module;

/**
 * Class DefaultController
 * @package modules\main\controllers\frontend
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor' => 0xF1F1F1,
                'foreColor' => 0xEE7600
            ]
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return mixed|Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if (Yii::$app->user->isGuest) {
            $model->scenario = $model::SCENARIO_GUEST;
        } else {
            $user = Yii::$app->user;
            /** @var User $identity */
            $identity = $user->identity;
            $model->name = $identity->username;
            $model->email = $identity->email;
        }
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                return $this->processSendEmail($model);
            }
        }
        return $this->render('contact', [
            'model' => $model
        ]);
    }

    /**
     * @param ContactForm $model
     * @return Response
     */
    protected function processSendEmail($model)
    {
        /** @var yii\web\Session $session */
        $session = Yii::$app->session;
        if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
            $session->setFlash(
                'success',
                Module::translate(
                    'module',
                    'Thank you for contacting us. We will respond to you as soon as possible.'
                )
            );
        } else {
            $session->setFlash('error', Module::translate('module', 'There was an error sending email.'));
        }
        return $this->refresh();
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
