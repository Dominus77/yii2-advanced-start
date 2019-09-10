<?php

namespace frontend\tests\acceptance;

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
        $I->amOnPage(Url::to(['/main/default/index']));
        $I->see('Congratulations!', 'h1');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}
