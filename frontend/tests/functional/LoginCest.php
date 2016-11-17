<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\User as UserFixture;

class LoginCest
{
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

    protected function formParams($email, $password)
    {
        return [
            'LoginForm[email]' => $email,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('E-mail cannot be blank');
        $I->seeValidationError('Password cannot be blank');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin@email.loc', 'wrong'));
        $I->seeValidationError('Incorrect email or password.');
    }
    
    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('sfriesen@jenkins.info', 'password_0'));
        $I->see('Profile (erau)', 'a');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
