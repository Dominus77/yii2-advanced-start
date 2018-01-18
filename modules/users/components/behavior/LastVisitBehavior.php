<?php

namespace modules\users\components\behavior;

use yii\base\Behavior;
use yii\console\Controller;

/**
 * Class LastVisitBehavior
 * @package modules\users\components\behavior
 */
class LastVisitBehavior extends Behavior
{
    /**
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_AFTER_ACTION => 'afterAction'
        ];
    }

    /**
     * @return bool
     */
    public function afterAction()
    {
        if (!\Yii::$app->user->isGuest) {
            $model = \Yii::$app->getUser()->getIdentity();
            $model->touch('last_visit');
        }
        return true;
    }
}
