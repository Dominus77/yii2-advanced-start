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

    public $email = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->getGravatar(80, 'mm', 'g', true, $this->imageOptions);
    }

    /**
     * @param int $s
     * @param string $d
     * @param string $r
     * @param bool|false $img
     * @param array $attr
     * @return string
     */
    public function getGravatar($s = 80, $d = 'mm', $r = 'g', $img = false, $attr = [])
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($this->email))) . '?';
        $url .= http_build_query([
            's' => $s,
            'd' => $d,
            'r' => $r,
        ]);

        return $img ? Html::img($url, $attr) : $url;
    }
}
