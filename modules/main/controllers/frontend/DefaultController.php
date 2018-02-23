<?php

namespace modules\main\controllers\frontend;

use Yii;
use yii\web\Controller;
use modules\main\models\frontend\ContactForm;
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
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor' => 0xF1F1F1,
                'foreColor' => 0xEE7600,
            ],
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
     * @return mixed|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if (Yii::$app->user->isGuest) {
            $model->scenario = $model::SCENARIO_GUEST;
        } else {
            $user = Yii::$app->user;
            /** @var \modules\users\models\User $identity */
            $identity = $user->identity;
            $model->name = $identity->username;
            $model->email = $identity->email;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->processSendEmail($model);
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * @param ContactForm $model
     * @return \yii\web\Response
     */
    protected function processSendEmail($model)
    {
        if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', Module::t('module', 'Thank you for contacting us. We will respond to you as soon as possible.'));
        } else {
            Yii::$app->session->setFlash('error', Module::t('module', 'There was an error sending email.'));
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
