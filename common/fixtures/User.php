<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class User extends ActiveFixture
{
    public $modelClass = 'modules\users\models\frontend\User';
}