<?php
namespace api\tests\acceptance;

use Yii;
use api\tests\AcceptanceTester;
use yii\helpers\Url;

class UserCest
{
    public function checkUsers(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('v1/users');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
