<?php
namespace console\controllers;

use Yii;
use common\models\User;
use yii\base\Model;
use yii\console\Controller;
use yii\console\Exception;
use console\components\helpers\Console;

/**
 * Class UsersController
 * @package app\modules\user\commands
 */
class UserController extends Controller
{
    public function actionIndex()
    {
        echo 'yii user/create' . PHP_EOL;
        echo 'yii user/remove' . PHP_EOL;
        echo 'yii user/activate' . PHP_EOL;
        echo 'yii user/change-password' . PHP_EOL;
    }

    public function actionCreate()
    {
        $model = new User();
        $this->readValue($model, 'username');
        $this->readValue($model, 'email');
        $model->setPassword($this->prompt(Console::convertEncoding(Yii::t('app', 'Password:')), [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => Console::convertEncoding(Yii::t('app', 'More than 6 symbols')),
        ]));
        $model->generateAuthKey();
        $model->status = $this->select(Console::convertEncoding(Yii::t('app', 'Status:')), Console::convertEncoding(User::getStatusesArray()));
        $this->log($model->save());
    }

    public function actionRemove()
    {
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $model = $this->findModel($username);
        $this->log($model->delete());
    }

    public function actionActivate()
    {
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $model = $this->findModel($username);
        $model->status = User::STATUS_ACTIVE;
        $model->removeEmailConfirmToken();
        $this->log($model->save());
    }

    public function actionChangePassword()
    {
        $username = $this->prompt(Console::convertEncoding(Yii::t('app', 'Username:')), ['required' => true]);
        $model = $this->findModel($username);
        $model->setPassword($this->prompt(Console::convertEncoding(Yii::t('app', 'New password:')), [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => Console::convertEncoding(Yii::t('app', 'More than 6 symbols')),
        ]));
        $this->log($model->save());
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

    /**
     * @param Model $model
     * @param string $attribute
     */
    private function readValue($model, $attribute)
    {
        $model->$attribute = $this->prompt(Console::convertEncoding(Yii::t('app', mb_convert_case($attribute, MB_CASE_TITLE, 'UTF-8') . ':')), [
            'validator' => function ($input, &$error) use ($model, $attribute) {
                $model->$attribute = $input;
                if ($model->validate([$attribute])) {
                    return true;
                } else {
                    $error = Console::convertEncoding(implode(',', $model->getErrors($attribute)));
                    return false;
                }
            },
        ]);
    }

    /**
     * @param bool $success
     */
    private function log($success)
    {
        if ($success) {
            $this->stdout(Console::convertEncoding(Yii::t('app', 'Success!')), Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr(Console::convertEncoding(Yii::t('app', 'Error!')), Console::FG_RED, Console::BOLD);
        }
        echo PHP_EOL;
    }
}