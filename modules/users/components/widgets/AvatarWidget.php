<?php

namespace modules\users\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;
use modules\users\models\User;

class AvatarWidget extends Widget
{
    public $imageOtions;
    public $defaultOptions;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        echo self::getAvatar();
    }

    private function getAvatar()
    {
        if(Yii::$app->user->identity->getAvatarPath())
            return Html::img(Yii::$app->user->identity->getAvatarPath(), $this->imageOtions);
        return Html::tag('i', '', $this->defaultOptions);
    }
}