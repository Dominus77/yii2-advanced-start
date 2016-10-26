<?php

namespace modules\users\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;
use modules\users\models\User;

class AvatarWidget extends Widget
{
    /**
     * Image options
     * <img class="img-circle">
     * @var array
     */
    public $imageOtions;

    /**
     * Default options tag
     * <i class="fa fa-user-circle fa-3x" style="color:#b9b9b9"></i>
     * @var
     */
    public $defaultOptions;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        echo self::getAvatar();
    }

    /**
     * @return string
     */
    private function getAvatar()
    {
        if(Yii::$app->user->identity->getAvatarPath())
            return Html::img(Yii::$app->user->identity->getAvatarPath(), $this->imageOtions);
        return Html::tag('i', '', $this->defaultOptions);
    }
}