<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 11.10.16
 * Time: 12:51
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use common\models\User;

class UserUpdateForm extends Model
{
    public $username;
    public $email;

    /**
     * @var User
     */
    private $_user;

    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function init()
    {
        $this->username = $this->_user->username;
        $this->email = $this->_user->email;
        parent::init();
    }

    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message' => Yii::t('app', 'ERROR_EMAIL_EXISTS'),
                'filter' => function (ActiveQuery $query) {
                    $query->andWhere(['<>', 'id', $this->_user->id]);
                },
            ],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Yii::t('app', 'CREATED'),
            'updated_at' => Yii::t('app', 'UPDATED'),
            'last_visit' => Yii::t('app', 'LAST_VISIT'),
            'username' => Yii::t('app', 'USERNAME'),
            'email' => Yii::t('app', 'EMAIL'),
            'status' => Yii::t('app', 'STATUS'),
            //'password' => Yii::t('app', 'PASSWORD'),
            'role' => Yii::t('app', 'ROLE'),
            'userRoleName' => Yii::t('app', 'ROLE'),
        ];
    }

    /**
     * @return bool
     */
    public function update()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->username = $this->username;
            $user->email = $this->email;
            return $user->save();
        } else {
            return false;
        }
    }
}