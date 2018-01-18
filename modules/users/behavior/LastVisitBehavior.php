<?php
namespace modules\users\behavior;

use yii\base\Behavior;
use yii\console\Controller;

/**
 * Class LastVisitBehavior
 * @package modules\users\behavior
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
