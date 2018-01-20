<?php

namespace common\components\helpers;

use Yii;

/**
 * Class MyHelpers
 * @package common\components\helpers
 */
class MyHelpers
{
    /**
     * @param string $message
     * @param string $type
     * @return \yii\web\Response
     */
    public static function goHome($message = '', $type = 'success')
    {
        if (!empty($message)) {
            Yii::$app->session->setFlash($type, $message);
        }
        return Yii::$app->controller->goHome();
    }
}
