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
        /** @var yii\web\User $user */
        $user = Yii::$app->user;
        return !empty($this->permission) && $user->can($this->permission);
    }

    /**
     * @return bool
     */
    protected function checkRole()
    {
        /** @var yii\web\User $user */
        $user = Yii::$app->user;
        return !empty($this->role) && $user->can($this->role);
    }

    /**
     * Logout and set Flash message
     */
    private function processLogout()
    {
        /** @var yii\web\User $user */
        $user = Yii::$app->user;
        if (!$user->isGuest) {
            $user->logout();
            /** @var yii\web\Session $session */
            $session = Yii::$app->session;
            $session->setFlash('error', Module::t('module', 'You are not allowed access!'));
        }
    }
}
