<?php
namespace modules\rbac\components\behavior;

use Yii;
use yii\base\Behavior;
use yii\console\Controller;

/**
 * Class AccessBehavior
 * @package modules\rbac\components\behavior
 */
class AccessBehavior extends Behavior
{
    /**
     * @var string
     */
    public $permission = '';

    /**
     * @var string
     */
    public $role = '';

    /**
     * @inheritdoc
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'accessAction'
        ];
    }

    /**
     * @inheritdoc
     */
    public function accessAction()
    {
        if (!empty($this->permission) && !$this->checkPermission()) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed access!'));
            }
        }

        if (!empty($this->role) && !$this->checkRole()) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed access!'));
            }
        }
    }

    /**
     * @return bool
     */
    protected function checkPermission()
    {
        if (!empty($this->permission)) {
            if (Yii::$app->user->can($this->permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function checkRole()
    {
        if (!empty($this->role)) {
            if (Yii::$app->user->can($this->role)) {
                return true;
            }
        }
        return false;
    }
}
