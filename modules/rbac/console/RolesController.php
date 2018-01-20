<?php
namespace modules\rbac\console;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use modules\users\models\User;
use console\components\helpers\Console;

/**
 * Class RolesController
 * @package modules\rbac\console
 */
class RolesController extends Controller
{
    /**
     * Adds role to user
     * @throws Exception
     */
    public function actionAssign()
    {
        $authManager = Yii::$app->authManager;
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $user = $this->findModel($username);

        $roles = Yii::$app->authManager->getRoles();
        $array = ArrayHelper::map($roles, 'name', 'description');
        $encodingArray = Console::convertEncoding($array);
        $select = is_array($encodingArray) ? $encodingArray : $array;
        $roleName = $this->select(Console::convertEncoding(Yii::t('app', 'Role:')), $select);
        $role = $authManager->getRole($roleName);

        // Проверяем есть ли уже такая роль у пользователя
        $userRoles = $this->getUserRoleValue($user->id);
        if ($userRoles === null) {
            $authManager->assign($role, $user->id);
            $this->stdout(Console::convertEncoding(Yii::t('app', 'Success!')), Console::FG_GREEN, Console::BOLD);
            $this->stdout(PHP_EOL);
        } else {
            $this->stdout(Console::convertEncoding(Yii::t('app', 'The user already has a role.')), Console::FG_RED, Console::BOLD);
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
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select(
            Console::convertEncoding(Yii::t('app', 'Role:')), ArrayHelper::merge(
            ['all' => Console::convertEncoding(Yii::t('app', 'All Roles'))],
            Console::convertEncoding(
                ArrayHelper::map($authManager->getRolesByUser($user->id), 'name', 'description')
            )
        )
        );
        if ($roleName == 'all') {
            $authManager->revokeAll($user->id);
        } else {
            $role = $authManager->getRole($roleName);
            $authManager->revoke($role, $user->id);
        }
        $this->stdout(Console::convertEncoding(Yii::t('app', 'Done!')), Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }

    /**
     * @param string $user_id
     * @return mixed|null
     */
    public function getUserRoleValue($user_id)
    {
        $authManager = Yii::$app->authManager;
        if ($role = $authManager->getRolesByUser($user_id)) {
            return ArrayHelper::getValue($role, function ($role) {
                foreach ($role as $key => $value) {
                    return $value->name;
                }
                return null;
            });
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
                Console::convertEncoding(
                    Yii::t('app', 'User "{:Username}" not found', [':Username' => $username])
                )
            );
        }
        return $model;
    }
}
