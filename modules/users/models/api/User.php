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
     * /api/users/1
     * @return array
     */
    public function fields()
    {
        return ['id', 'email', 'username', 'first_name', 'last_name'];
    }

    /**
     * /api/users/1?expand=status
     * @return array
     */
    public function extraFields()
    {
        return ['status', 'created_at', 'updated_at', 'last_visit', 'registration_type'];
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        Yii::$app->security->derivationIterations = 1;
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}