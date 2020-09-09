<?php

namespace modules\users\commands;

use yii\base\Model;
use yii\console\Controller;
use yii\console\Exception;
use yii\db\StaleObjectException;
use console\components\helpers\Console;
use modules\users\models\User;
use modules\users\Module;
use Throwable;

/**
 * Console user actions
 * @package app\modules\user\commands
 */
class UserController extends Controller
{
    /**
     * Color
     * @var bool
     */
    public $color = true;

    /**
     * Console user actions
     */
    public function actionIndex()
    {
        echo 'yii users/user/create' . PHP_EOL;
        echo 'yii users/user/remove' . PHP_EOL;
        echo 'yii users/user/activate' . PHP_EOL;
        echo 'yii users/user/set-status' . PHP_EOL;
        echo 'yii users/user/get-status' . PHP_EOL;
        echo 'yii users/user/change-password' . PHP_EOL;
    }

    /**
     * Create new user
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new User();
        $this->readValue($model, 'username');
        $this->readValue($model, 'email');
        $model->setPassword($this->prompt(Module::translate('module', 'Password:'), [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => Module::translate('module', 'More than 6 symbols'),
        ]));
        $model->generateAuthKey();
        if (($select = User::getStatusesArray()) && is_array($select)) {
            $model->status = $this->select(Module::translate('module', 'Status:'), $select);
            $this->log($model->save());
        } else {
            $this->log();
        }
    }

    /**
     * Remove user
     * @throws Exception
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionRemove()
    {
        $username = $this->prompt(Module::translate('module', 'Username') . ':', ['required' => true]);
        $model = $this->findModel($username);
        if ($model->delete() !== false) {
            $this->log(true);
        } else {
            $this->log(false);
        }
    }

    /**
     * Change status user to active
     * @throws Exception
     */
    public function actionActivate()
    {
        $username = $this->prompt(Module::translate('module', 'Username:'), ['required' => true]);
        $model = $this->findModel($username);
        $model->status = User::STATUS_ACTIVE;
        $model->removeEmailConfirmToken();
        $this->log($model->save());
    }

    /**
     * Get status name to user
     * @throws Exception
     */
    public function actionGetStatus()
    {
        $username = $this->prompt(Module::translate('module', 'Username') . ':', ['required' => true]);
        $model = $this->findModel($username);
        $this->stdout($model->statusName, Console::FG_GREEN, Console::BOLD);
    }

    /**
     * Change select status user
     * @throws Exception
     */
    public function actionSetStatus()
    {
        $username = $this->prompt(Module::translate('module', 'Username') . ':', ['required' => true]);
        $model = $this->findModel($username);
        if (($select = User::getStatusesArray()) && is_array($select)) {
            $model->status = $this->select(Module::translate('module', 'Status') . ':', $select);
            $this->log($model->save());
        }
    }

    /**
     * Change password
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionChangePassword()
    {
        $username = $this->prompt(Module::translate('module', 'Username:'), ['required' => true]);
        $model = $this->findModel($username);
        $model->setPassword($this->prompt(Module::translate('module', 'New password:'), [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => Module::translate('module', 'More than 6 symbols'),
        ]));
        $this->log($model->save());
    }

    /**
     * Find model user
     * @param string $username
     * @return User
     * @throws Exception
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

    /**
     * @param Model|null $model
     * @param string $attribute
     */
    private function readValue($model = null, $attribute = '')
    {
        $model->$attribute = $this->prompt(
            Module::translate(
                'module',
                mb_convert_case($attribute, MB_CASE_TITLE, 'UTF-8')
            ) . ':',
            [
                'validator' => static function ($input, &$error) use ($model, $attribute) {
                    /** @var string $input */
                    $model->$attribute = $input;
                    /** @var Model $model */
                    if ($model->validate([$attribute])) {
                        return true;
                    }
                    $error = implode(',', $model->getErrors($attribute));
                    return false;
                },
            ]
        );
    }

    /**
     * @param bool|int $success
     */
    private function log($success = false)
    {
        if ($success === true || $success !== 0) {
            $this->stdout(Module::translate('module', 'Success!'), Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr(Module::translate('module', 'Error!'), Console::FG_RED, Console::BOLD);
        }
        echo PHP_EOL;
    }
}
