<?php

namespace modules\users\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use modules\users\traits\ModuleTrait;
use modules\users\Module;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property int $id ID
 * @property int $user_id User
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property string $email_gravatar Email Gravatar
 * @property int $last_visit Last Visit
 * @property int $created_at Created
 * @property int $updated_at Updated
 *
 * @property User $user
 *
 * @method touch(string $attribute)
 */
class UserProfile extends ActiveRecord
{
    use ModuleTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'last_visit', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['email_gravatar'], 'email'],
            [['email_gravatar'], 'unique'],
            [
                'user_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::translate('module', 'ID'),
            'user_id' => Module::translate('module', 'User'),
            'first_name' => Module::translate('module', 'First Name'),
            'last_name' => Module::translate('module', 'Last Name'),
            'email_gravatar' => Module::translate('module', 'Email Gravatar'),
            'last_visit' => Module::translate('module', 'Last Visit'),
            'created_at' => Module::translate('module', 'Created'),
            'updated_at' => Module::translate('module', 'Updated'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
