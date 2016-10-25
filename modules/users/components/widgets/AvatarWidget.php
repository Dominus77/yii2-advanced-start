<?php

namespace modules\users\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\url;
use modules\users\models\User;

class AvatarWidget extends Widget {

    public $uploads;
    public $defaultAvatar;
    public $model;

    public function init()
    {
        parent::init();
        $this->uploads = $this->uploads ? $this->uploads : Yii::$app->getModule('users')->uploads;
        $this->defaultAvatar = $this->defaultAvatar ? $this->defaultAvatar : Yii::$app->getModule('user')->defaultAvatar;
    }

    public function run()
    {
        echo $this->getAvatar() ? $this->getAvatar() : $this->getDefaultAvatar();
    }

    /**
     * @return mixed
     */
    private function getAvatar()
    {
        $userPath = Url::to(DIRECTORY_SEPARATOR . $this->uploads . DIRECTORY_SEPARATOR . $this->model->id);
        return $this->model->profile->avatar ? str_replace('\\', '/',$userPath . DIRECTORY_SEPARATOR . $this->model->avatar) : null;
    }

    /**
     * @return bool|mixed
     */
    private function getDefaultAvatar()
    {
        $defaultPath = Url::to('@upload') . DIRECTORY_SEPARATOR . $this->uploads . DIRECTORY_SEPARATOR . 'default';
        $dataFile = Url::to('@modules') . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR .'data' . DIRECTORY_SEPARATOR . $this->uploads . DIRECTORY_SEPARATOR . 'default' .  DIRECTORY_SEPARATOR . $this->defaultAvatar;
        $newFile = $defaultPath . DIRECTORY_SEPARATOR . $this->defaultAvatar;

        if(!file_exists($defaultPath))
        {
            mkdir($defaultPath, 0700, true);
            if (!copy($dataFile, $newFile)) {
                return false;
            }
        }
        $urlDefaultAvatar = str_replace('\\', '/', Url::to(DIRECTORY_SEPARATOR . $this->uploads . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . $this->defaultAvatar));
        return $urlDefaultAvatar;
    }

}