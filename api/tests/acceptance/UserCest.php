<?php

namespace api\tests\acceptance;

use Yii;
use api\tests\FunctionalTester;
use yii\helpers\Url;

/**
 * Class UserCest
 * @package api\tests\acceptance
 */
class UserCest
{
    /**
     * @param FunctionalTester $I
     */
    public function checkUsers(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET(Url::to('users'));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
