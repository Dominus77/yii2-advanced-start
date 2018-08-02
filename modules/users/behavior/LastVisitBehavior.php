<?php

namespace modules\users\behavior;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use modules\users\models\User;

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
            /** @var \yii\behaviors\TimestampBehavior|User $model Updates a timestamp attribute to the current timestamp. */
            if($model->profile !== null) {
                $model->profile->touch('last_visit');
            }
        }
        return true;
    }
}
