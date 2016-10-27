<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 09.10.16
 * Time: 3:20
 */

namespace modules\users\models\frontend;

use Yii;
use yii\helpers\ArrayHelper;
use modules\users\Module;

class User extends \modules\users\models\User
{
    const SCENARIO_PROFILE_UPDATE = 'profileUpdate';
    const SCENARIO_PROFILE_DELETE = 'profileDelete';

    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['newPassword', 'string', 'min' => self::LENGTH_STRING_PASSWORD_MIN, 'max' => self::LENGTH_STRING_PASSWORD_MAX],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
            ['currentPassword', 'validateCurrentPassword', 'skipOnEmpty' => false, 'skipOnError' => false],
        ]);
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!empty($this->newPassword) && !empty($this->newPasswordRepeat) && !$this->hasErrors()) {
            if($this->$attribute) {
                if (!$this->validatePassword($this->$attribute))
                    $this->addError($attribute, Module::t('frontend', 'MSG_INCORRECT_CURRENT_PASSWORD'));
            } else {
                $this->addError($attribute, Module::t('frontend', 'MSG_INPUT_CURRENT_PASSWORD'));
            }
        }
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PROFILE_UPDATE] = ['avatar', 'isDel', 'email', 'currentPassword', 'newPassword', 'newPasswordRepeat', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_PROFILE_DELETE] = ['status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'currentPassword' => Module::t('frontend', 'CURRENT_PASSWORD'),
            'newPassword' => Module::t('frontend', 'NEW_PASSWORD'),
            'newPasswordRepeat' => Module::t('frontend', 'REPEAT_PASSWORD'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->newPassword)) {
                $this->setPassword($this->newPassword);
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        // Защита от удаления самого себя
        if ($this->id == Yii::$app->user->identity->getId()) {
            return false;
        }
        return true;
    }
}