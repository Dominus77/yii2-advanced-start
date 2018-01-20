<?php

namespace common\components\helpers;

use Yii;

/**
 * Class Helpers
 * @package components\helpers
 */
class Helpers
{
    /**
     * Set Message and Redirect Home
     * @param string $type
     * @param string $message
     * @return bool|\yii\web\Response
     */
    public static function goHome($type = 'success', $message = '')
    {
        if (!empty($message)) {
            Yii::$app->session->setFlash($type, $message);
        }
        $controller = Yii::$app->controller;
        return $controller->goHome();
    }
}
