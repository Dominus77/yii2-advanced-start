<?php

namespace common\components\maintenance\actions\frontend;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\web\Session;
use common\components\maintenance\models\SubscribeForm;

/**
 * Class SubscribeAction
 * @package common\components\maintenance\actions\frontend
 */
class SubscribeAction extends Action
{
    /**
     * @return Response
     */
    public function run()
    {
        $model = new SubscribeForm();
        $msgSuccess = Yii::t('app', 'We will inform you when everything is ready!');
        $msgInfo = Yii::t('app', 'You have already subscribed to the alert!');
        if (($post = Yii::$app->request->post()) && $model->load($post) && $model->validate()) {
            /** @var Session $session */
            $session = Yii::$app->session;
            if ($model->subscribe()) {
                $session->setFlash($model::SUBSCRIBE_SUCCESS, $msgSuccess);
            } else {
                $session->setFlash($model::SUBSCRIBE_INFO, $msgInfo);
            }
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
