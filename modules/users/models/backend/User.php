<?php
/**
 * Created by PhpStorm.
 * User: Alexey Schevchenko <ivanovosity@gmail.com>
 * Date: 09.10.16
 * Time: 3:20
 */

namespace modules\users\models\backend;

use Yii;
use yii\helpers\ArrayHelper;
use modules\users\Module;

class User extends \modules\users\models\User
{
    const SCENARIO_ADMIN_CREATE = 'adminCreate';
    const SCENARIO_ADMIN_UPDATE = 'adminUpdate';
    const SCENARIO_PASSWORD_UPDATE = 'adminPasswordUpdate';
    const SCENARIO_AVATAR_UPDATE = 'adminAvatarUpdate';
    const SCENARIO_PROFILE_DELETE = 'adminProfileDelete';

    public $newPassword;
    public $newPasswordRepeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['newPassword', 'newPasswordRepeat'], 'required', 'on' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_PASSWORD_UPDATE]],
            ['newPassword', 'string', 'min' => self::LENGTH_STRING_PASSWORD_MIN],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN_CREATE] = ['avatar', 'username', 'email', 'status', 'role', 'newPassword', 'newPasswordRepeat', 'registration_type', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_ADMIN_UPDATE] = ['username', 'email', 'status', 'role', 'first_name', 'last_name'];
        $scenarios[self::SCENARIO_PASSWORD_UPDATE] = ['newPassword', 'newPasswordRepeat'];
        $scenarios[self::SCENARIO_AVATAR_UPDATE] = ['isDel'];
        $scenarios[self::SCENARIO_PROFILE_DELETE] = ['status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'newPassword' => Module::t('backend', 'New Password'),
            'newPasswordRepeat' => Module::t('backend', 'Repeat Password'),
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
            // У нас статус всегда активный
            /*if ($this->id == Yii::$app->user->identity->getId()) {
                $this->status = self::STATUS_ACTIVE;
            }*/
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
        /*if ($this->id == Yii::$app->user->identity->getId()) {
            return false;
        }*/
        return true;
    }
}