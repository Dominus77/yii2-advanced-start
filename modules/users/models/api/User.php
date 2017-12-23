<?php

namespace modules\users\models\api;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class User
 * @package modules\users\models\api
 */
class User extends \modules\users\models\User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(\modules\users\models\User::rules(), []);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(\modules\users\models\User::attributeLabels(), []);
    }

    /**
     * /api/v1/user
     * @return array
     */
    public function fields()
    {
        return ['id', 'email', 'username', 'first_name', 'last_name'];
    }

    /**
     * /api/v1/users?expand=status
     * @return array
     */
    public function extraFields()
    {
        return ['status', 'created_at', 'updated_at', 'last_visit', 'registration_type'];
    }
}