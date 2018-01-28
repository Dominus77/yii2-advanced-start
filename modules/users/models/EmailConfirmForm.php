<?php

namespace modules\users\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use modules\users\Module;

/**
 * Class EmailConfirmForm
 * @package modules\users\models\frontend
 */
class EmailConfirmForm extends Model
{
    /**
     * @var \modules\users\models\BaseUser|bool
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  mixed $token
     * @param  array $config
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token = '', $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Module::t('module', 'Email confirm token cannot be blank.'));
        }
        $this->_user = BaseUser::findByEmailConfirmToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Module::t('module', 'Wrong Email confirm token.'));
        }
        parent::__construct($config);
    }

    /**
     * Confirm email.
     *
     * @return bool|\yii\rbac\Assignment if email was confirmed.
     * @throws \Exception
     */
    public function confirmEmail()
    {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();
        if ($user->save()) {
            // Даём роль по умолчанию
            $authManager = Yii::$app->getAuthManager();
            $role = $authManager->getRole(\modules\rbac\models\Role::ROLE_DEFAULT);
            return $authManager->assign($role, $user->id);
        }
        return false;
    }
}
