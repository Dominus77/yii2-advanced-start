<?php

namespace modules\rbac\components\behavior;

use Yii;
use yii\base\Behavior;
use yii\console\Controller;
use modules\rbac\Module;

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
        if (($this->checkPermission() === false) && ($this->checkRole() === false)) {
            $this->processLogout();
        }
    }

    /**
     * @return bool
     */
    protected function checkPermission()
    {
        return !empty($this->permission) && Yii::$app->user->can($this->permission);
    }

    /**
     * @return bool
     */
    protected function checkRole()
    {
        return !empty($this->role) && Yii::$app->user->can($this->role);
    }

    /**
     * Logout and set Flash message
     */
    private function processLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('error', Module::t('module', 'You are not allowed access!'));
        }
    }
}
