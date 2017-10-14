<?php
/**
 * Created by PhpStorm.
 * User: Alexey Schevchenko <ivanovosity@gmail.com>
 * Date: 07.10.16
 * Time: 5:48
 */

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
     */
    public function actionAssign()
    {
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select(Console::convertEncoding(Yii::t('app', 'Role:')), Console::convertEncoding(ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description')));
        $authManager = Yii::$app->getAuthManager();
        $role = $authManager->getRole($roleName);

        // Проверяем есть ли уже такая роль у пользователя
        $userRoles = self::getUserRoleValue($user->id);
        if($userRoles === null) {
            $authManager->assign($role, $user->id);
            $this->stdout(Console::convertEncoding(Yii::t('app', 'Done!')), Console::FG_GREEN, Console::BOLD);
            $this->stdout(PHP_EOL);
        } else {
            $this->stdout(Console::convertEncoding(Yii::t('app', 'The user already has a role.')), Console::FG_RED, Console::BOLD);
            $this->stdout(PHP_EOL);
        }
    }

    /**
     * Removes role from user
     */
    public function actionRevoke()
    {
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select(
            Console::convertEncoding(Yii::t('app', 'Role:')), ArrayHelper::merge(
            ['all' => Console::convertEncoding(Yii::t('app', 'All Roles'))],
            Console::convertEncoding(
                ArrayHelper::map(Yii::$app->authManager->getRolesByUser($user->id), 'name', 'description')
            )
        )
        );
        $authManager = Yii::$app->getAuthManager();
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
     * @param null $user_id
     * @return mixed|null
     */
    public function getUserRoleValue($user_id = null)
    {
        if ($role = Yii::$app->authManager->getRolesByUser($user_id)) {
            return ArrayHelper::getValue($role, function ($role, $defaultValue) {
                foreach ($role as $key => $value) {
                    return $value->name;
                }
                return null;
            });
        }
        return null;
    }

    /**
     * @param string $username
     * @throws \yii\console\Exception
     * @return \modules\users\models\User the loaded model
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