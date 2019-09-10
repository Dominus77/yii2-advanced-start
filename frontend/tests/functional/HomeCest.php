<?php

namespace frontend\tests\functional;

use Yii;
use frontend\tests\FunctionalTester;

/**
 * Class HomeCest
 * @package frontend\tests\functional
 */
class HomeCest
{
    /**
     * @param FunctionalTester $I
     */
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see('Congratulations!');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}
