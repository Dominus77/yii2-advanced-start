<?php

namespace common\components\behavior;

use yii\base\Behavior;
use yii\console\Controller;

class LastVisitBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_AFTER_ACTION => 'afterAction'
        ];
    }

    public function afterAction()
    {
        if (!\Yii::$app->user->isGuest) {
            $model = \Yii::$app->getUser()->getIdentity();
            $model->touch('last_visit');
        }
        return true;
    }
}