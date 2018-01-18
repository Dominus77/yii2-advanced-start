<?php

namespace modules\users\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;
use modules\users\models\User;

/**
 * Class AvatarWidget
 * @package modules\users\widgets
 */
class AvatarWidget extends Widget
{
    /**
     * Image options
     * <img class="img-circle">
     * @var array
     */
    public $imageOptions = [
        'class' => 'img-circle',
    ];

    public $gravatar = false;

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
        if(($this->gravatar === false) && Yii::$app->user->identity->getAvatarPath())
            return Html::img(Yii::$app->user->identity->getAvatarPath(), $this->imageOptions);
        return Yii::$app->user->identity->getGravatar(null, 80, 'mm', 'g', true, $this->imageOptions);
    }
}
