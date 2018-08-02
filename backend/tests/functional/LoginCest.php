<?php
namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\User as UserFixture;

/**
 * Class LoginCest
 * @package backend\tests\functional
 */
class LoginCest
{
    /**
     * @param FunctionalTester $I
     */
    function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ]);
        $I->amOnRoute('/users/default/login');
    }

    /**
     * @param $email
     * @param $password
     * @return array
     */
    protected function formParams($email, $password)
    {
        return [
            'LoginForm[email]' => $email,
            'LoginForm[password]' => $password,
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
    }

    /**
     * @param FunctionalTester $I
     */
    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin@email.loc', 'wrong'));
        $I->seeValidationError('Invalid email or password.');
    }

    /**
     * @param FunctionalTester $I
     */
    public function checkValidLoginAccessDenied(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('tester@jenkins.info', 'password_0'));
        $I->see('You do not have rights, access is denied.');
    }
}
