<?php

namespace api\tests\functional;

use api\tests\FunctionalTester;

/**
 * Class UserCest
 * @package api\tests\functional
 */
class UserCest
{
    /**
     * @param FunctionalTester $I
     */
    public function checkUsers(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('v1/users');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
