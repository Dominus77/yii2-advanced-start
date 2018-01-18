<?php

namespace frontend\tests\acceptance;

use Yii;
use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

/**
 * Class HomeCest
 * @package frontend\tests\acceptance
 */
class HomeCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('Yii2-advanced-start');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}
