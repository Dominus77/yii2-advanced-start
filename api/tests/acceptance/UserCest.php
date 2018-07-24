<?php

namespace api\tests\acceptance;

use Yii;
use api\tests\AcceptanceTester;
use yii\helpers\Url;

/**
 * Class UserCest
 * @package api\tests\acceptance
 */
class UserCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function checkUsers(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET(Url::to('v1/users'));
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
