<?php

namespace modules\users\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use modules\users\models\User;
use modules\users\models\UploadForm;

/**
 * Class AvatarWidget
 * @package modules\users\widgets
 *
 * @property array $imageOptions
 * @property string $email
 * @property int|string $user_id
 * @property-read string|int $userId
 * @property-read string $gravatarEmail
 * @property string|int $size
 */
class AvatarWidget extends Widget
{
    public $imageOptions = [
        'class' => 'img-circle',
    ];
    public $email = '';
    public $user_id;
    public $size = '150';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->email = !empty($this->email) ? $this->email : $this->getGravatarEmail();
        $this->user_id = !empty($this->user_id) ? $this->user_id : $this->getUserId();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new UploadForm();
        $fileName = $model->getFileName();
        $avatar = $model->getPath($this->user_id) . DIRECTORY_SEPARATOR . $fileName;
        if (file_exists($avatar)) {
            echo Html::img(
                [
                    '/users/profile/avatar',
                    'filename' => 'avatar.jpg',
                    'id' => $this->user_id
                ],
                $this->imageOptions
            );
        } else {
            echo $this->getGravatar($this->email, $this->size, 'mm', 'g', true, $this->imageOptions);
        }
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param bool $img True to return a complete IMG tag False for just the URL
     * @param array $attr Optional, additional key/value attributes to include in the IMG tag
     * @return string containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    public function getGravatar($email = '', $s = '80', $d = 'mm', $r = 'g', $img = false, $attr = [])
    {
        $data = ['email' => $email, 's' => $s, 'd' => $d, 'r' => $r];
        $key = 'gravatar_' . md5($email);
        $duration = 60 * 60; // 3600 сек или 1 час
        $cache = Yii::$app->cache;
        $url = $cache->getOrSet($key, function () use ($data) {
            return $this->calculateSomething($data);
        }, $duration);
        return $img ? Html::img($url, $attr) : $url;
    }

    /**
     * @param array $data
     * @return string
     */
    protected function calculateSomething($data = [])
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($data['email']))) . '?';
        $url .= http_build_query([
            's' => $data['s'],
            'd' => $data['d'],
            'r' => $data['r'],
        ]);
        return $url;
    }

    /**
     * @return string
     */
    public function getGravatarEmail()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        return (!Yii::$app->user->isGuest) ? $user->profile->email_gravatar : $this->email;
    }

    /**
     * @return int|string
     */
    public function getUserId()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        return (!Yii::$app->user->isGuest) ? $user->id : $this->user_id;
    }
}
