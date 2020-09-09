<?php

namespace modules\rbac\console;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use modules\users\models\User;
use console\components\helpers\Console;
use modules\rbac\Module;

/**
 * Class RolesController
 * @package modules\rbac\console
 */
class RolesController extends Controller
{
    /**
     * Color
     * @var bool
     */
    public $color = true;

    /**
     * Adds role to user
     * @throws Exception
     * @throws \Exception
     */
    public function actionAssign()
    {
        $authManager = Yii::$app->authManager;
        $username = $this->prompt(Module::translate('module', 'Username:'), ['required' => true]);
        $user = $this->findModel($username);

        $roles = Yii::$app->authManager->getRoles();
        $select = ArrayHelper::map($roles, 'name', 'description');
        /*$encodingArray = Console::convertEncoding($array);
        $select = is_array($encodingArray) ? $encodingArray : $array;*/
        $roleName = $this->select(Module::translate('module', 'Role:'), $select);
        $role = $authManager->getRole($roleName);

        // Проверяем есть ли уже такая роль у пользователя
        $userRoles = $this->getUserRoleValue($user->id);
        if ($userRoles === null) {
            $authManager->assign($role, $user->id);
            $this->stdout(
                Module::translate('module', 'Success!'),
                Console::FG_GREEN,
                Console::BOLD
            );
            $this->stdout(PHP_EOL);
        } else {
            $this->stdout(
                Module::translate('module', 'The user already has a role.'),
                Console::FG_RED,
                Console::BOLD
            );
            $this->stdout(PHP_EOL);
        }
    }

    /**
     * Removes role from user
     * @throws Exception
     */
    public function actionRevoke()
    {
        $authManager = Yii::$app->authManager;
        $username = $this->prompt(Module::translate('module', 'Username:'), ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select(
            Module::translate('module', 'Role:'),
            ArrayHelper::merge(
                ['all' => Module::translate('module', 'All Roles')],
                ArrayHelper::map($authManager->getRolesByUser($user->id), 'name', 'description')
            )
        );
        if ($roleName === 'all') {
            $authManager->revokeAll($user->id);
        } else {
            $role = $authManager->getRole($roleName);
            $authManager->revoke($role, $user->id);
        }
        $this->stdout(Module::translate('module', 'Success!'), Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }

    /**
     * @param string|int $user_id
     * @return mixed|null
     */
    public function getUserRoleValue($user_id)
    {
        $authManager = Yii::$app->authManager;
        if ($role = $authManager->getRolesByUser($user_id)) {
            return array_key_first($role);
        }
        return null;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $username
     * @return User the loaded model
     * @throws Exception if the model cannot be found
     */
    private function findModel($username)
    {
        if (!$model = User::findOne(['username' => $username])) {
            throw new Exception(
                Module::translate('module', 'User "{:Username}" not found', [':Username' => $username])
            );
        }
        return $model;
    }
}
