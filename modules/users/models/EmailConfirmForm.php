<?php

namespace modules\users\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\rbac\Assignment;
use modules\rbac\models\Role;
use modules\users\Module;
use Exception;

/**
 * Class EmailConfirmForm
 * @package modules\users\models\frontend
 */
class EmailConfirmForm extends Model
{
    /**
     * @var User|bool
     */
    private $user;

    /**
     * Creates a form model given a token.
     *
     * @param mixed $token
     * @param array $config
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token = '', $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException(
                Module::translate(
                    'module',
                    'Email confirm token cannot be blank.'
                )
            );
        }
        $this->user = User::findByEmailConfirmToken($token);
        if (!$this->user) {
            throw new InvalidArgumentException(Module::translate('module', 'Wrong Email confirm token.'));
        }
        parent::__construct($config);
    }

    /**
     * Confirm email.
     *
     * @return bool|Assignment if email was confirmed.
     * @throws Exception
     */
    public function confirmEmail()
    {
        $user = $this->user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();
        if ($user->save(false)) {
            // Даём роль по умолчанию
            $authManager = Yii::$app->getAuthManager();
            if (!$authManager->getRolesByUser($user->id)) {
                $role = $authManager->getRole(Role::ROLE_DEFAULT);
                return $authManager->assign($role, $user->id);
            }
            return true;
        }
        return false;
    }
}
