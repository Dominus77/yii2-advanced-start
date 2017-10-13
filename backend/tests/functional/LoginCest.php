<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\User as UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    public function _before(FunctionalTester $I)
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
        $I->seeValidationError('Email cannot be blank');
        $I->seeValidationError('Password cannot be blank');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin@email.loc', 'wrong'));
        $I->seeValidationError('Invalid email or password.');
    }

    public function checkValidLoginAccessDenied(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('sfriesen@jenkins.info', 'password_0'));
        $I->see('You do not have rights, access is denied.');
    }
}
