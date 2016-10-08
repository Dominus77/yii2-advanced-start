<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 07.10.16
 * Time: 5:48
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use common\models\User;
use console\components\helpers\Console;

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
        $authManager->assign($role, $user->id);
        $this->stdout(Console::convertEncoding(Yii::t('app', 'Done!')) . PHP_EOL);
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
        $this->stdout(Console::convertEncoding(Yii::t('app', 'Done!')) . PHP_EOL);
    }

    /**
     * @param string $username
     * @throws \yii\console\Exception
     * @return User the loaded model
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