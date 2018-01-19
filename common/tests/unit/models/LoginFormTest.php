<?php

namespace common\tests\unit\models;

use Yii;
use modules\users\models\LoginForm;
use common\fixtures\User as UserFixture;

/**
 * Class LoginFormTest
 * @package common\tests\unit\models
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'email' => 'not_existing_username@test.loc',
            'password' => 'not_existing_password',
        ]);

        expect('model should not login user', $model->login())->false();
        expect('user should not be logged in', Yii::$app->user->isGuest)->true();
    }

    /**
     * @inheritdoc
     */
    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'email' => 'bayer.hudson@test.loc',
            'password' => 'wrong_password',
        ]);

        expect('model should not login user', $model->login())->false();
        expect('error message should be set', $model->errors)->hasKey('password');
        expect('user should not be logged in', Yii::$app->user->isGuest)->true();
    }

    /**
     * @inheritdoc
     */
    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'email' => 'nicole.paucek@schultz.info',
            'password' => 'password_0',
        ]);

        expect('model should login user', $model->login())->true();
        expect('error message should not be set', $model->errors)->hasntKey('password_hash');
        expect('user should be logged in', Yii::$app->user->isGuest)->false();
    }
}
