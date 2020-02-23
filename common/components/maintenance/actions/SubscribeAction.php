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
     * @return array|Response
     */
    public function run()
    {
        $model = new SubscribeForm();
        $msgSuccess = Yii::t('app', 'We will inform you when everything is ready!');
        if (($post = Yii::$app->request->post()) && $model->load($post) && $model->validate()) {
            if (Yii::$app->request->isAjax && $model->subscribe()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'result' => $msgSuccess
                ];
            }
            if ($model->subscribe()) {
                Yii::$app->session->setFlash('SUBSCRIBE_SUCCESS', $msgSuccess);
            }
        }
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
