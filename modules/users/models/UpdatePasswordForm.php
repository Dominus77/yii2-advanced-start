<?php

namespace modules\users\models;

use yii\base\Model;
use yii\base\InvalidArgumentException;
use modules\users\Module;

/**
 * Class UpdatePasswordForm
 * @package modules\users\models
 */
class UpdatePasswordForm extends Model
{
    public $newPassword;
    public $newPasswordRepeat;
    public $currentPassword;

    /**
     * @var \modules\users\models\User
     */
    private $_user;

    /**
     * UpdatePasswordForm constructor.
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        if (!$this->_user) {
            throw new InvalidArgumentException(Module::t('module', 'User not found.'));
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['newPassword', 'newPasswordRepeat', 'currentPassword'], 'required'],
            ['newPassword', 'string', 'min' => User::LENGTH_STRING_PASSWORD_MIN, 'max' => User::LENGTH_STRING_PASSWORD_MAX],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
            ['currentPassword', 'validateCurrentPassword', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    /**
     * @param string $attribute
     */
    public function validateCurrentPassword($attribute)
    {
        if (!empty($this->newPassword) && !empty($this->newPasswordRepeat) && !$this->hasErrors()) {
            $this->processValidatePassword($attribute);
        } else {
            $this->addError($attribute, Module::t('module', 'Not all fields are filled in correctly.'));
        }
    }

    /**
     * @param string $attribute
     */
    protected function processValidatePassword($attribute)
    {
        if ($attribute) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, Module::t('module', 'Incorrect current password.'));
            }
        } else {
            $this->addError($attribute, Module::t('module', 'Enter your current password.'));
        }
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => Module::t('module', 'New Password'),
            'newPasswordRepeat' => Module::t('module', 'Repeat Password'),
            'currentPassword' => Module::t('module', 'Current Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     * @throws \yii\base\Exception
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->newPassword);
        return $user->save();
    }
}
