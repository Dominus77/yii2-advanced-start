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
     * @inheritdoc
     */
    public function actionIndex()
    {
        echo 'yii rbac/roles/assign - Assign user role.' . PHP_EOL;
        echo 'yii rbac/roles/revoke - Revoke user role.' . PHP_EOL;
    }

    /**
     * Adds role to user
     */
    public function actionAssign()
    {
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $user = $this->findModel($username);

        $array = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        $select = is_array($array) ? $array : [];

        $roleName = $this->select(Console::convertEncoding(Yii::t('app', 'Role:')), Console::convertEncoding($select));

        $authManager = Yii::$app->getAuthManager();
        $role = $authManager->getRole($roleName);

        // Проверяем есть ли уже такая роль у пользователя
        if ($userRoles = $this->getUserRoleValue($user->id)) {
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
     * @param integer $user_id
     * @return mixed|false
     */
    public function getUserRoleValue($user_id)
    {
        if (is_integer($user_id)) {
            $authManager = Yii::$app->authManager;
            if ($role = $authManager->getRolesByUser($user_id)) {
                return ArrayHelper::getValue($role, function ($role) {
                    foreach ($role as $key => $value) {
                        return $value->name;
                    }
                    return false;
                });
            }
        }
        return false;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $username
     * @return null|User the loaded model
     * @throws \yii\console\Exception if the model cannot be found
     */
    private function findModel($username = '')
    {
        if (($model = User::findOne(['username' => $username])) !== null) {
            return $model;
        }
        throw new Exception(Console::convertEncoding(Yii::t('app', 'User "{:Username}" not found', [':Username' => $username])));
    }
}
