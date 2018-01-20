<?php

namespace modules\users\behavior;

use Yii;
use yii\base\Behavior;
use yii\console\Controller;

/**
 * Class LastVisitBehavior
 * @package modules\users\behavior
 */
class LastVisitBehavior extends Behavior
{
    /**
     * @inheritdoc
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
        if (!Yii::$app->user->isGuest) {
            /** @var \yii\web\IdentityInterface $model */
            $model = Yii::$app->user->identity;
            /** @var \yii\behaviors\TimestampBehavior $model Updates a timestamp attribute to the current timestamp. */
            $model->touch('last_visit');
        }
        return true;
    }
}
