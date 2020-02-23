<?php


namespace common\components\maintenance\actions;

use Yii;
use yii\base\Action;
use yii\web\Response;
use common\components\maintenance\models\SubscribeForm;

/**
 * Class SubscribeAction
 * @package common\components\maintenance\actions
 *
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
            if ($model->subscribe()) {
                Yii::$app->session->setFlash('SUBSCRIBE_SUCCESS', $msgSuccess);
            } else {
                Yii::$app->session->setFlash('SUBSCRIBE_INFO', $msgInfo);
            }
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
