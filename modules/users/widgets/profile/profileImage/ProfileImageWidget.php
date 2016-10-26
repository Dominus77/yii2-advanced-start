<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 26.10.16
 * Time: 14:04
 */

namespace modules\users\widgets\profile\profileImage;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\users\models\User;

class ProfileImageWidget extends Widget
{
    /**
     * @var object modules\users\models\User
     */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        echo $this->render('index', [
            'data' => self::getData(),
        ]);
    }

    /**
     * @return array
     */
    private function getData()
    {
        return [
            'avatar' => self::getAvatarPath(),
            'username' => self::getUserName(),
            'role' => self::getUserRole(),
        ];
    }

    /**
     * @return null|string
     */
    private function getAvatarPath()
    {
        if ($this->model->avatar != null) {
            $upload = Yii::$app->getModule('users')->uploads;
            $path = Yii::$app->params['domainFrontend'] . '/' . $upload . '/' . $this->model->id . '/' . $this->model->avatar;
            return $path;
        }
        return null;
    }

    /**
     * @return null|string
     */
    private function getUserName()
    {
        if ($this->model) {
            if ($this->model->first_name && $this->model->last_name) {
                $fullName = $this->model->first_name . ' ' . $this->model->last_name;
            } else if ($this->model->first_name) {
                $fullName = $this->model->first_name;
            } else if ($this->model->last_name) {
                $fullName = $this->model->last_name;
            } else {
                $fullName = $this->model->username;
            }
            return Html::encode($fullName);
        }
        return null;
    }

    /**
     * @return mixed|null
     */
    private function getUserRole()
    {
        if ($role = Yii::$app->authManager->getRolesByUser($this->model->id))
            return ArrayHelper::getValue($role, function ($role, $defaultValue) {
                foreach ($role as $key => $value) {
                    return $value->description;
                }
                return null;
            });
        return null;
    }
}