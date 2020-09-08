<?php
namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\fixtures\User as UserFixture;
use frontend\tests\UnitTester;
use modules\users\models\SignupForm;
use modules\users\models\User;

/**
 * Class SignupFormTest
 * @package frontend\tests\unit\models
 */
class SignupFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function _before() // phpcs:ignore
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $user = $model->signup();

        expect($user)->isInstanceOf(User::class);

        expect($user->username)->equals('some_username');
        expect($user->email)->equals('some_email@example.com');
        expect($user->validatePassword('some_password'))->true();
    }

    /**
     * @inheritdoc
     */
    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));
    }
}
