<?php

namespace common\fixtures;

use yii\test\ActiveFixture;
use modules\users\models\User as BaseUser;

/**
 * Class User
 * @package common\fixtures
 */
class User extends ActiveFixture
{
    public $modelClass = BaseUser::class;
}
