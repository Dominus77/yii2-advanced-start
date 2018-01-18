<?php
namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\User as UserFixture;

/**
 * Class LoginCest
 * @package frontend\tests\functional
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
                'class' => UserFixture::className(),
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
    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('sfriesen@jenkins.info', 'password_0'));
        $I->see('Profile (erau)', 'a');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
